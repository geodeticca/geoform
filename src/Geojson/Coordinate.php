<?php

namespace Geodeticca\Geoform\Geojson;

class Coordinate implements \JsonSerializable
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
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return [
            $this->lon,
            $this->lat,
        ];
    }
}
