<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 20:44
 */


namespace App\Security;


class TokenGenerator
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function getRandomSecureToken(int $length = 30): string
    {
        $token = '';
        $maxNumber = strlen(self::ALPHABET);

        for ($i = 0; $i < $length; $i++) {
            $token .= self::ALPHABET[random_int(0, $maxNumber - 1)];
        }

        return $token;
    }
}
