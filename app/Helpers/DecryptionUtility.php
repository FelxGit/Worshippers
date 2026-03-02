<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class DecryptionUtility
{
    /**
     * DecryptionUtility::decryptCookie($encryptedCookieValue)
     * return the cookie value
     *
     * @param String $encryptedCookieValue
     * @return Object|null
     */
    public static function decryptCookie($encryptedCookieValue)
    {
        try {
            $decryptedPayload = Crypt::decryptString($encryptedCookieValue);

            // Split the string into parts
            $parts = explode('|', $decryptedPayload);

            if (count($parts) !== 2) {
                \Log::error('Error: decryptCookie() - format count');
            }

            $decryptedValue = json_decode($parts[1]);

            // Return the decrypted payload
            return $decryptedValue;
        } catch (\Exception $e) {
            return null; // or throw an exception
        }
    }
}
