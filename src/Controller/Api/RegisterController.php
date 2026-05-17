<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        SerializerInterface $serializer,
    ): JsonResponse {

     try {
        $user = $serializer->deserialize(
            $request->getContent(),
            User::class,
            'json', 
            [
                    'object_to_populate' => new User(),
            ]
        ); 
     } catch (\Throwable $e) {
            return $this->json([
                'message' => 'JSON invalide'
            ], 400);
        }

     $user->setPassword($hasher->hashPassword($user, $user->getPassword()));

     if (!$user->getEmail() || !$user->getPassword() || !$user->getFirstName() || !$user->getLastName()) {
            return $this->json(['message' => 'Tous les champs sont requis.'], 400);
        }

    if ($userRepository->findOneBy(['email' => $user->getEmail()])) {
            return $this->json(['message' => 'Cet email est déjà utilisé.'], 409);
        }

     $em->persist($user);   
     $em->flush();   


        // $data = json_decode($request->getContent(), true);

        // $email     = $data['email'] ?? null;
        // $password  = $data['password'] ?? null;
        // $firstName = $data['firstName'] ?? null;
        // $lastName  = $data['lastName'] ?? null;

        // if (!$email || !$password || !$firstName || !$lastName) {
        //     return $this->json(['message' => 'Tous les champs sont requis.'], 400);
        // }

        // if ($userRepository->findOneBy(['email' => $email])) {
        //     return $this->json(['message' => 'Cet email est déjà utilisé.'], 409);
        // }

        // $user = new User();
        // $user->setEmail($email);
        // $user->setFirstName($firstName);
        // $user->setLastName($lastName);
        // $user->setPassword($hasher->hashPassword($user, $password));

        // $em->persist($user);
        // $em->flush();

        return $this->json(['message' => 'Compte créé avec succès.'], 201);
    }
}
