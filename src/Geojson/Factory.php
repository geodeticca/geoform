<?php

namespace Geodeticca\Geoform\Geojson;

class Factory
{
    /**
     * @param mixed $geom
     * @param array $properties
     * @return \Geodeticca\Geoform\Geojson\Feature
     */
    public static function buildFeatureFromGeometry(mixed $geom, array $properties = []): Feature
    {
        if (is_string($geom)) {
            $geom = json_decode($geom, true);
        }

        $feature = new Feature();
        $feature->setGeometry($geom);
        $feature->setProperties($properties);

        return $feature;
    }

    /**
     * @param array $geoms
     * @return \Geodeticca\Geoform\Geojson\FeatureCollection
     */
    public static function buildFeatureCollectionFromGeometries(array $geoms): FeatureCollection
    {
        $geoms = array_map(function ($item) {
            if (is_string($item)) {
                return json_decode($item, true);
            }
        }, $geoms);

        $featureCollection = new FeatureCollection();

        foreach ($geoms as $geom) {
            $feature = new Feature();
            $feature->setGeometry($geom);

            $featureCollection->addFeature($feature);
        }

        return $featureCollection;
    }
}
