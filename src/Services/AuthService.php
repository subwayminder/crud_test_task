<?php

namespace Subwayminder\CrudTestTask\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Subwayminder\CrudTestTask\Entity\User;
use Subwayminder\CrudTestTask\Requests\Auth\RegisterRequest;
use Firebase\JWT\JWT;

class AuthService
{
    private EntityRepository|ObjectRepository $repository;
    public function __construct(public readonly EntityManager $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(User::class);
    }
    public function createUser(RegisterRequest $request): string
    {
        $user = new User();
        $user->setFirstName($request->getFirstName());
        $user->setLastName($request->getLastName());
        $user->setEmail($request->getEmail());
        $user->setPassword($request->getPassword());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $user = $this->repository->findOneBy(['email' => $request->getEmail()]);
        return $this->getToken($user);
    }

    public function login(string $email, string $password): string|bool
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => $email]);
        if (!password_verify($password, $user->getPasswordHash())) return false;
        return $this->getToken($user);
    }

    public function getToken(User $user): string
    {
        $token = [
            "iss" => $_ENV['APP_URL'],
            "aud" => $_ENV['APP_URL'],
            "iat" => time(),
            "nbf" => time(),
            "data" => [
                "id" => $user->getId(),
                "firstname" => $user->getFirstName(),
                "lastname" => $user->getLastName(),
                "email" => $user->getEmail()
            ]
        ];
        return JWT::encode($token, $_ENV['JWT_SECRET'], 'HS256');
    }

    public function checkUser(string $email): bool
    {
        $result = $this->repository->findOneBy([
            'email' => $email
        ]);
        return (bool)$result;
    }
}