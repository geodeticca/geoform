<?php

namespace Geodeticca\Geoform\Transformer;

use Geodeticca\Geoform\Geojson\Feature as GeojsonFeature;
use Geodeticca\Geoform\Geojson\FeatureCollection as GeojsonFeatureCollection;
use Geodeticca\Geoform\Esrijson\Feature as EsrijsonFeature;
use Geodeticca\Geoform\Esrijson\FeatureCollection as EsrijsonFeatureCollection;

class Esrijson
{
    /**
     * @param mixed $esriJson - ESRI JSON string or array (can be geometry, feature, or FeatureSet)
     * @return \Geodeticca\Geoform\Geojson\FeatureCollection|\Geodeticca\Geoform\Geojson\Feature
     */
    public static function esriJsonToGeojson(mixed $esriJson): GeojsonFeatureCollection|GeojsonFeature
    {
        if (is_string($esriJson)) {
            $esriJson = json_decode($esriJson, true);
        }

        if (array_key_exists('features', $esriJson)) {
            $esrijsonObject = new EsrijsonFeatureCollection();
        } else {
            $esrijsonObject = new EsrijsonFeature();
        }

        $esrijsonObject->hydrate($esriJson);

        return $esrijsonObject->toGeojson();
    }
}
