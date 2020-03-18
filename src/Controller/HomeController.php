<?php

namespace App\Controller;

use App\Form\Home\SearchFormType;
use App\Service\EtablissementPublicApi;
use App\Service\GeoApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GeoApi $geoApi
     * @param EtablissementPublicApi $etablissementPublicApi
     * @param Request $request
     * @return Response
     */
    public function index(GeoApi $geoApi, EtablissementPublicApi $etablissementPublicApi, Request $request)
    {
        $newArray = array();

        $form = $this->createForm(SearchFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $commune = $data['commune'];
            $code = $data['code'];

            if (!isset($commune) && !isset($code)) {
                return $this->render('error/index.html.twig', [
                    'message' => 'Both fields are empty...',
                ]);
            }

            $commune ? $results = $geoApi->getCommune($commune) : $results = $geoApi->getCode($code);

            if (!$results) {
                return $this->render('error/index.html.twig', [
                    'message' => 'There is no data for this search...',
                ]);
            }

            foreach ($results as $result) {
                $codeUnique = $result['code'];
                $result['extraInformations'] = $etablissementPublicApi->getFacilities($codeUnique);
                array_push($newArray, $result);
            }

            return $this->render('home/index.html.twig', [
                'search_form' => $form->createView(),
                'results' => $newArray,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }
}
