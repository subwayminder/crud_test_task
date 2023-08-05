<?php

namespace Subwayminder\CrudTestTask\Controllers;

use Subwayminder\CrudTestTask\Entity\User;
use Subwayminder\CrudTestTask\Requests\Auth\LoginRequest;
use Subwayminder\CrudTestTask\Requests\Auth\RegisterRequest;
use Subwayminder\CrudTestTask\Services\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function __construct(private readonly AuthService $authService)
    {
    }
    public function register(RegisterRequest $request): void
    {
        if ($this->authService->checkUser($request->getEmail())) {
            $response = new JsonResponse(
                [
                    'message' => 'User already exists'
                ],
                Response::HTTP_OK
            );
            $response->send();
            return;
        }
        $response = new JsonResponse(
            [
                'token' => $this->authService->createUser($request)
            ],
            Response::HTTP_UNAUTHORIZED
        );
        $response->send();
    }

    public function login(LoginRequest $request): void
    {
        if ($this->authService->checkUser($request->getEmail())) {
            $token = $this->authService->login($request->getEmail(), $request->getPassword());
            $response = $token
                ? new JsonResponse(['token' => $token], Response::HTTP_OK)
                : new JsonResponse(['message' => 'Password do not match'], Response::HTTP_OK);
        } else {
            $response = new JsonResponse(
                [
                    'message' => 'User not found'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $response->send();
    }
}