<?php

namespace Potassium\App\Entities;

use Potassium\App\Entities\Pays;
use Potassium\App\Entities\Entity;

class Continent extends Entity
{
    public function pays()
    {
        return $this->hasMany(Pays::class);
    }
}
