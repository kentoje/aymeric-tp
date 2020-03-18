<?php

namespace App\Service;


class Helper
{
    static public function getInformations(string $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $response = curl_exec($ch);

        $result = json_decode($response, true);

        curl_close($ch);

        if (!$result) {
            $result = array();
        }

        return $result;
    }
}