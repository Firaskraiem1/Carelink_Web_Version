<?php

namespace App\Model;

use App\Entity\Medecin;

class SearchMedecin
{

    public string $nom;
    public ?Medecin $medecin = null;
}
