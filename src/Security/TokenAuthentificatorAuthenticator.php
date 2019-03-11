<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthentificatorAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    
    }
    
    
    public function supports(Request $request)
    {
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
             'token' => $request->query->get(key, 'token'),
        ];

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->userRepository->finOnBy(['token' => $credentials['token'],]);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($credentials['token'] === $user->getToken()){
            $user->setToken('');
            $this->entityManager->persist($user);
            $this->entityManager->flus;


            return true;
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response( 'Yes');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new Response('Vous n\'êtes pas connecte');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
