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
     * @var float|null
     */
    public ?float $z = null;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            $this->lon,
            $this->lat,
        ];

        if ($this->z !== null) {
            $data[] = $this->z;
        }

        return $data;
    }
}
