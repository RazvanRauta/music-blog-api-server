<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 21:17
 */


namespace App\Entity;


interface UserEntityInterface
{
    public function setUser(User $user): UserEntityInterface;

}