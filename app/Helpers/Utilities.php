<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

trait Utilities
{
    /**
     * @param array $row
     * @return bool
     *
     * Дані повинні валідуватися при імпорті та:
     * заборонені поштові домени: mail.ru, ya.ru
     * дозвонені країни: ua, uk, us
     *
     * Цей метод непогано було би покрити тестами.
     */
    protected function isAllowedRow(array $row) : bool
    {
        $notAllowedMailDomains = ['mail.ru', 'ya.ru']; //Hardcoded data!!!
        $allowedCountries = ['ua', 'uk', 'us']; //Hardcoded data!!!

        $email  = mb_strtolower($row['email']);
        $country = mb_strtolower($row['country']);

        $domain = substr(strrchr($email, "@"), 1);

        if (in_array($domain, $notAllowedMailDomains, true)) {
            return false;
        }

        return in_array($country, $allowedCountries, true);
    }

    protected function genFileName(): string
    {
        return bin2hex(Hash::make(time()));
    }
}
