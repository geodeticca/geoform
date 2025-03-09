<?php

namespace Geodeticca\Geoform\Geojson;

class Factory
{
    public static function buildFeatureFromGeometry($geom, array $properties = [])
    {
        if (is_string($geom)) {
            $geom = json_decode($geom);
        }

        $feature = new Feature();
        $feature->seGeometry($geom);
        $feature->setProperties($properties);

        return [
            'type' => 'Feature',
            'geometry' => $geom,
            'properties' => (object)$properties,
        ];
    }
}
