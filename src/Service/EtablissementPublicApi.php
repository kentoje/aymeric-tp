<?php

namespace App\Service;


class EtablissementPublicApi
{
    public function getFacilities(string $code): array
    {
        $url = 'https://etablissements-publics.api.gouv.fr/v3/communes/'. $code .'/mairie';

        return Helper::getInformations($url);
    }
}
