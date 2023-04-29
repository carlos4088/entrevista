<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use App\Entity\User;

class AuthController extends AbstractController
{
    private $encoder;
    private $jwtManager;

    public function __construct(UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $jwtManager)
    {
        $this->encoder = $encoder;
    $this->jwtManager = $jwtManager;
    }

    public function login(Request $request)
    {
        $email = json_decode($request->getContent(), true)['email'];
        $password = json_decode($request->getContent(), true)['password'];

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            throw new BadCredentialsException();
        }

        $isPasswordValid = $this->encoder->isPasswordValid($user, $password);

        if (!$isPasswordValid) {
            throw new BadCredentialsException();
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
