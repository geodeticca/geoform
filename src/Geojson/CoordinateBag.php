<?php

namespace Geodeticca\Geoform\Geojson;

class CoordinateBag
{
    /**
     * @var array
     */
    public array $bag = [];

    /**
     * @param \Geodeticca\Geoform\Geojson\Coordinate $coordinate
     * @return $this
     */
    public function addCoordinate(Coordinate $coordinate): self
    {
        $this->bag[] = $coordinate;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item->toArray();
        }, $this->bag);
    }
}
