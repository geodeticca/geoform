<?php

namespace Geodeticca\Geoform\Geojson;

class Factory
{
    /**
     * @param mixed $geom
     * @param array $properties
     * @return array
     */
    public static function buildFeatureFromGeometry(mixed $geom, array $properties = []) : array
    {
        if (is_string($geom)) {
            $geom = json_decode($geom, true);
        }

        $feature = new Feature();
        $feature->setGeometry($geom);
        $feature->setProperties($properties);

        return [
            'type' => 'Feature',
            'geometry' => $geom,
            'properties' => $properties,
        ];
    }
}
