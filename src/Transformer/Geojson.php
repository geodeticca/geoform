<?php

namespace Geodeticca\Geoform\Transformer;

use Geodeticca\Geoform\Geojson\FeatureCollection as GeojsonFeatureCollection;
use Geodeticca\Geoform\Esrijson\FeatureCollection as EsrijsonFeatureCollection;
use Geodeticca\Geoform\Geojson\Factory as GeojsonFactory;

class Geojson
{
    /**
     * Convert GeoJSON to ESRI JSON format
     *
     * @param array|GeojsonFeatureCollection $geojson
     * @return array
     */
    public static function geojsonToEsriJson(mixed $geojson): EsrijsonFeatureCollection
    {
        if (is_string($geojson)) {
            $geojson = json_decode($geojson, true);
        }

        if (!is_array($geojson)) {
            throw new \InvalidArgumentException('Input must be an array or FeatureCollection');
        }

        $features = [];

        if (isset($geojson['type']) && $geojson['type'] === 'FeatureCollection') {
            $features = $geojson['features'] ?? [];
        } elseif (isset($geojson['type']) && $geojson['type'] === 'Feature') {
            $features = [$geojson];
        } else {
            throw new \InvalidArgumentException('Invalid GeoJSON structure');
        }

        $esriFeatures = [];
        foreach ($features as $feature) {
            $esriFeatures[] = self::convertFeature($feature, $wkid);
        }

        return $esriFeatures;
    }

    /**
     * Convert a single GeoJSON feature to ESRI JSON feature
     *
     * @param array $feature
     * @param int $wkid
     * @return array
     */
    private static function convertFeature(array $feature, int $wkid): array
    {
        $esriFeature = [
            'attributes' => $feature['properties'] ?? [],
        ];

        if (isset($feature['geometry'])) {
            $esriFeature['geometry'] = self::convertGeometry($feature['geometry'], $wkid);
        }

        return $esriFeature;
    }

    /**
     * Convert GeoJSON geometry to ESRI JSON geometry
     *
     * @param array $geometry
     * @param int $wkid
     * @return array
     */
    private static function convertGeometry(array $geometry, int $wkid): array
    {
        $type = $geometry['type'] ?? '';
        $coordinates = $geometry['coordinates'] ?? [];

        $spatialReference = ['wkid' => $wkid];

        switch ($type) {
            case 'Point':
                return [
                    'x' => $coordinates[0],
                    'y' => $coordinates[1],
                    'spatialReference' => $spatialReference,
                ];

            case 'MultiPoint':
                return [
                    'points' => $coordinates,
                    'spatialReference' => $spatialReference,
                ];

            case 'LineString':
                return [
                    'paths' => [$coordinates],
                    'spatialReference' => $spatialReference,
                ];

            case 'MultiLineString':
                return [
                    'paths' => $coordinates,
                    'spatialReference' => $spatialReference,
                ];

            case 'Polygon':
                return [
                    'rings' => $coordinates,
                    'spatialReference' => $spatialReference,
                ];

            case 'MultiPolygon':
                $rings = [];
                foreach ($coordinates as $polygon) {
                    foreach ($polygon as $ring) {
                        $rings[] = $ring;
                    }
                }
                return [
                    'rings' => $rings,
                    'spatialReference' => $spatialReference,
                ];

            default:
                throw new \InvalidArgumentException("Unsupported geometry type: {$type}");
        }
    }
}
