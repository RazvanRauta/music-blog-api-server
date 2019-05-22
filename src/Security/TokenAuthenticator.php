<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 20:45
 */


namespace App\Security;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @param PreAuthenticationJWTUserToken $preAuthToken
     * @param UserProviderInterface $userProvider
     * @return null|UserInterface|void
     */
    public function getUser($preAuthToken, UserProviderInterface $userProvider)
    {
        /** @var User $user */
        $user = parent::getUser(
            $preAuthToken,
            $userProvider
        );


        return $user;
    }

}