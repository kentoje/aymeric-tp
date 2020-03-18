<?php

namespace App\Service;


class EtablissementPublicApi
{
    public function getFacilities(string $code): Array
    {
        $url = 'https://etablissements-publics.api.gouv.fr/v3/communes/'. $code .'/mairie';

        return Helper::getInformations($url);
    }
}
