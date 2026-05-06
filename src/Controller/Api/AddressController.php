<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/addresses')]
final class AddressController extends AbstractController
{
    #[Route('', name: 'api_addresses_list', methods: ['GET'])]
    public function list(AddressRepository $repo): JsonResponse
    {
        $user = $this->getUser();

        $addresses = $repo->findBy(['user' => $user]);

        return $this->json($addresses, 200, [], [
            'groups' => ['address:read']
        ]);
    }

    #[Route('', name: 'api_addresses_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        $user = $this->getUser();

        try {
            /** @var Address $address */
            $address = $serializer->deserialize(
                $request->getContent(),
                Address::class,
                'json',
                [
                    'object_to_populate' => new Address(),
                    'groups' => ['address:write']
                ]
            );
        } catch (\Throwable $e) {
            return $this->json([
                'message' => 'JSON invalide'
            ], 400);
        }

        $address->setUser($user);

        $errors = $validator->validate($address);

        if (count($errors) > 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }

            return $this->json([
                'message' => 'Données invalides',
                'errors' => $messages
            ], 400);
        }

        if ($address->isDefault()) {
            foreach ($user->getAddresses() as $existing) {
                $existing->setIsDefault(false);
            }
        }

        $em->persist($address);
        $em->flush();

        return $this->json($address, 201, [], [
            'groups' => ['address:read']
        ]);
    }

    #[Route('/{id}', name: 'api_addresses_update', methods: ['PUT'])]
    public function update(int $id, Request $request, AddressRepository $repo, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse {
        $user = $this->getUser();

        $address = $repo->findOneBy([
            'id' => $id,
            'user' => $user
        ]);

        if (!$address) {
            return $this->json(['message' => 'Adresse introuvable.'], 404);
        }

        $serializer->deserialize(
            $request->getContent(),
            Address::class,
            'json',
            [
                'object_to_populate' => $address,
                'groups' => ['address:write']
            ]
        );

        if ($address->isDefault()) {
            foreach ($user->getAddresses() as $existing) {
                if ($existing->getId() !== $id) {
                    $existing->setIsDefault(false);
                }
            }
        }

        $em->flush();

        return $this->json($address, 200, [], [
            'groups' => ['address:read']
        ]);
    }

    #[Route('/{id}', name: 'api_addresses_delete', methods: ['DELETE'])]
    public function delete(int $id, AddressRepository $repo, EntityManagerInterface $em): JsonResponse {
        $user = $this->getUser();

        $address = $repo->findOneBy([
            'id' => $id,
            'user' => $user
        ]);

        if (!$address) {
            return $this->json(['message' => 'Adresse introuvable.'], 404);
        }

        $em->remove($address);
        $em->flush();

        return $this->json(null, 204);
    }
}