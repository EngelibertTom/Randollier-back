<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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
    public function updateProfile(Request $request, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        if (isset($data['firstName'])) $user->setFirstName($data['firstName']);
        if (isset($data['lastName']))  $user->setLastName($data['lastName']);
        if (isset($data['email']))     $user->setEmail($data['email']);
        if (array_key_exists('phone', $data)) $user->setPhone($data['phone'] ?: null);
        if (array_key_exists('birthdate', $data)) {
            $user->setBirthdate($data['birthdate']
                ? new \DateTimeImmutable($data['birthdate'])
                : null
            );
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
