<?php

namespace App\Traits;

use App\Helper\DB;
use App\Model\City;

trait HasCity
{
    public int $city_id;

    public function getCity(DB $db = null ): City | false
    {
        return City::Find($this->city_id, $db);
    }

    public function __get(string $name)
    {
        if ($name === "city") {
            return $this->getCity();
        }
    }

}