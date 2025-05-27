<?php

namespace Geodeticca\Geoform\Geojson;

class Factory
{
    /**
     * @param mixed $geom
     * @param array $properties
     * @return \Geodeticca\Geoform\Geojson\Feature
     */
    public static function buildFeatureFromGeometry(mixed $geom, array $properties = []) : Feature
    {
        if (is_string($geom)) {
            $geom = json_decode($geom, true);
        }

        $feature = new Feature();
        $feature->setGeometry($geom);
        $feature->setProperties($properties);

        return $feature;
    }
}
