<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/addresses')]
final class AddressController extends AbstractController
{
    #[Route('', name: 'api_addresses_list', methods: ['GET'])]
    public function list(AddressRepository $repo): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->json(array_map(
            fn($addr) => $this->serialize($addr),
            $repo->findByUser($user)
        ));
    }

    #[Route('', name: 'api_addresses_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $address = new Address();
        $address->setUser($user);
        $this->hydrate($address, $data);

        if ($address->isDefault()) {
            foreach ($user->getAddresses() as $existing) {
                $existing->setIsDefault(false);
            }
        }

        $em->persist($address);
        $em->flush();

        return $this->json($this->serialize($address), 201);
    }

    #[Route('/{id}', name: 'api_addresses_update', methods: ['PUT'])]
    public function update(int $id, Request $request, AddressRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user    = $this->getUser();
        $address = $repo->find($id);

        if (!$address || $address->getUser() !== $user) {
            return $this->json(['message' => 'Adresse introuvable.'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $this->hydrate($address, $data);

        if ($address->isDefault()) {
            foreach ($user->getAddresses() as $existing) {
                if ($existing->getId() !== $id) {
                    $existing->setIsDefault(false);
                }
            }
        }

        $em->flush();

        return $this->json($this->serialize($address));
    }

    #[Route('/{id}', name: 'api_addresses_delete', methods: ['DELETE'])]
    public function delete(int $id, AddressRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user    = $this->getUser();
        $address = $repo->find($id);

        if (!$address || $address->getUser() !== $user) {
            return $this->json(['message' => 'Adresse introuvable.'], 404);
        }

        $em->remove($address);
        $em->flush();

        return $this->json(null, 204);
    }

    private function hydrate(Address $address, array $data): void
    {
        $address->setLabel($data['label'] ?? null);
        $address->setFirstName($data['firstName'] ?? '');
        $address->setLastName($data['lastName'] ?? '');
        $address->setStreet($data['street'] ?? '');
        $address->setCity($data['city'] ?? '');
        $address->setPostalCode($data['postalCode'] ?? '');
        $address->setCountry($data['country'] ?? '');
        $address->setIsDefault($data['isDefault'] ?? false);
    }

    private function serialize(Address $addr): array
    {
        return [
            'id'         => $addr->getId(),
            'label'      => $addr->getLabel() ?? '',
            'firstName'  => $addr->getFirstName(),
            'lastName'   => $addr->getLastName(),
            'street'     => $addr->getStreet(),
            'city'       => $addr->getCity(),
            'postalCode' => $addr->getPostalCode(),
            'country'    => $addr->getCountry(),
            'isDefault'  => $addr->isDefault(),
        ];
    }
}
