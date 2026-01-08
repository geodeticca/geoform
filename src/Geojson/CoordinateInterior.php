<?php

namespace Geodeticca\Geoform\Geojson;

interface CoordinateInterior
{
    /**
     * @param \Geodeticca\Geoform\Geojson\CoordinateBag $coordinateBag
     * @return $this
     */
    public function add(CoordinateBag $coordinateBag): self;
}
