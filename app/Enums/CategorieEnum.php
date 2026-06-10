<?php

namespace App\Enums;

enum CategorieEnum: string
{
    case Alimentaire = 'alimentaire';
    case Boissons = 'boissons';
    case Hygiene = 'hygiene';
    case Entretien = 'entretien';
    case Autre = 'autre';
}
