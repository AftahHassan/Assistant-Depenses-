<?php

namespace App\Enums;

enum StatutEnum: string
{
    case EnAttente = 'en_attente';
    case Traite = 'traite';
    case Echoue = 'echoue';
}
