<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    private $encoder;
    private $jwtManager;

    public function __construct(UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $jwtManager)
    {
        $this->encoder = $encoder;
        $this->jwtManager = $jwtManager;
    }

    public function register(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
		
        $user->setEmail(json_decode($request->getContent(), true)['email']);
        $user->setRoles(['ROLE_USER']); 
        $user->setPassword($this->encoder->encodePassword($user, json_decode($request->getContent(), true)['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }

	
	public function getUsers(SerializerInterface $serializer)
	{

		$users = $this->getDoctrine()->getRepository(User::class)->findAll();

		$json = $serializer->serialize(['users' => $users], 'json');

		return new JsonResponse($json, 200, [], true);
	}
}
