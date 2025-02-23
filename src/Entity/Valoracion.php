<?php

namespace App\Entity;
enum Valoracion:string{
    case MUY_BUENA="Muy buena";
    case BUENA="Buena";
    case REGULAR="Regular";
    case MALA="Mala";
    case SIN_VALORACION="Sin valoración";
}