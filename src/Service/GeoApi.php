<?php

namespace App\Service;


class GeoApi
{
    public function getCommune(string $city): array
    {
        $url = 'https://geo.api.gouv.fr/communes?nom='. $city .'&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre';

        return Helper::getInformations($url);
    }

    public function getCode(string $code): array
    {
        $url = 'https://geo.api.gouv.fr/communes?codePostal='. $code .'&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre';

        return Helper::getInformations($url);
    }
}
