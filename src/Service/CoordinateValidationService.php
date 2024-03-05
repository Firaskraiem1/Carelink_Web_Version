<?php

namespace App\Service;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Entity\ParaPharmacie;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoordinateValidationService
{
    private $httpClient;
  public function __construct(HttpClientInterface $httpClient) 
  {
    $this->httpClient = $httpClient;
  }

  public function validateCoordinates(ParaPharmacie $para, ExecutionContextInterface $context)
  {
    $zone = $para->getVille();

    $response = $this->httpClient->request('GET', "https://maps.googleapis.com/maps/api/geocode/json?address={$zone->getVille()}&key=API_KEY");

    $data = json_decode($response->getContent());

    $lat_zone = $data->results[0]->geometry->location->lat;

    $lng_zone = $data->results[0]->geometry->location->lng;

    if(abs($para->getLatitude() - $lat_zone) > 0.05 || abs($para->getLongitude() - $lng_zone) > 0.05) {

      $context->buildViolation("Les coordonnées ne correspondent pas à la zone")->addViolation();

    }

  }

}