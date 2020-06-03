<?php

namespace Potassium\App\Entities;

use Potassium\App\Entities\Entity;
use Potassium\App\Entities\Continent;

class Pays extends Entity
{
    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }
}
