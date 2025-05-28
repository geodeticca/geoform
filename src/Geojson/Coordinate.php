<?php

namespace Geodeticca\Geoform\Geojson;

class Coordinate
{
    /**
     * @var float
     */
    public float $lon;

    /**
     * @var float
     */
    public float $lat;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->lon,
            $this->lat,
        ];
    }
}
