<?php

namespace Geodeticca\Geoform\Geojson;

class CoordinatePath implements CoordinateInterior
{
    /**
     * @var array
     */
    public array $bag = [];

    /**
     * @param \Geodeticca\Geoform\Geojson\CoordinateBag $coordinateBag
     * @return $this
     */
    public function add(CoordinateBag $coordinateBag): self
    {
        $this->bag[] = $coordinateBag;

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
