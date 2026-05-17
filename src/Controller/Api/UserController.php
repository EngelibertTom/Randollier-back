<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->json([
            'email'     => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'phone'     => $user->getPhone(),
            'birthdate' => $user->getBirthdate()?->format('Y-m-d'),
        ]);
    }

    #[Route('/api/profile', name: 'api_profile_update', methods: ['PUT'])]
    public function updateProfile(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        try {
            $serializer->deserialize(
                $request->getContent(),
                User::class,
                'json',
                [
                    'object_to_populate' => $user,
                    'groups'             => ['user:write'],
                ]
            );
        } catch (\Throwable $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }

        $data = json_decode($request->getContent(), true);
        if (array_key_exists('birthdate', $data)) {
            $user->setBirthdate($data['birthdate'] ? new \DateTimeImmutable($data['birthdate']) : null);
        }

        $em->flush();

        return $this->json([
            'email'     => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'phone'     => $user->getPhone(),
            'birthdate' => $user->getBirthdate()?->format('Y-m-d'),
        ]);
    }
}
