<?php

namespace Geodeticca\Geoform\Geojson;

class FeatureCollection
{
    /**
     * @var string
     */
    public string $type = 'FeatureCollection';

    /**
     * @var array
     */
    public array $features = [];
}
