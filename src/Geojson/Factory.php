<?php

namespace Geodeticca\Geoform\Geojson;

class Factory
{
    /**
     * @param array $geojson
     * @return FeatureCollection|Feature
     */
    public static function parse(array $geojson): FeatureCollection|Feature
    {
        if (!is_array($geojson)) {
            throw new \InvalidArgumentException('Input must be an array or string');
        }

        if (array_key_exists('type', $geojson)) {
            if ($geojson['type'] === 'FeatureCollection') {
                $featureCollection = new FeatureCollection();
                $featureCollection->hydrate($geojson);

                return $featureCollection;
            } elseif ($geojson['type'] === 'Feature') {
                $feature = new Feature();
                $feature->hydrate($geojson);

                return $feature;
            } else {
                throw new \InvalidArgumentException('Invalid GeoJSON type');
            }
        } else {
            throw new \InvalidArgumentException('Invalid GeoJSON structure');
        }
    }

    /**
     * @param mixed $feat
     * @return \Geodeticca\Geoform\Geojson\Feature
     */
    public static function buildFeature(mixed $feat): Feature
    {
        if (is_string($feat)) {
            $feat = json_decode($feat, true);
        }

        $feature = new Feature();
        $feature->hydrate($feat);

        return $feature;
    }

    /**
     * @param mixed $geom
     * @return \Geodeticca\Geoform\Geojson\Feature
     */
    public static function buildFeatureFromGeometry(mixed $geom): Feature
    {
        if (is_string($geom)) {
            $geom = json_decode($geom, true);
        }

        $feature = new Feature();
        $feature->createGeometry($geom);

        return $feature;
    }

    /**
     * @param array $geoms
     * @return \Geodeticca\Geoform\Geojson\FeatureCollection
     */
    public static function buildFeatureCollectionFromGeometries(array $geoms): FeatureCollection
    {
        $featureCollection = new FeatureCollection();

        foreach ($geoms as $geom) {
            $feature = self::buildFeatureFromGeometry($geom);

            $featureCollection->addFeature($feature);
        }

        return $featureCollection;
    }
}
