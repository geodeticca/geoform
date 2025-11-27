<?php

namespace Geodeticca\Geoform\Esrijson;

class Factory
{
    /**
     * Build ESRI JSON geometry object from JSON string or array
     * Automatically detects geometry type and creates appropriate object
     *
     * @param string|array $geometry
     * @return \Geodeticca\Geoform\Esrijson\Point|\Geodeticca\Geoform\Esrijson\Multipoint|\Geodeticca\Geoform\Esrijson\Polyline|\Geodeticca\Geoform\Esrijson\Polygon
     * @throws \InvalidArgumentException
     */
    public static function buildFromJson(string|array $geometry): Point|Multipoint|Polyline|Polygon
    {
        if (is_string($geometry)) {
            $geometry = json_decode($geometry, true);
        }

        if (!is_array($geometry)) {
            throw new \InvalidArgumentException('Invalid geometry data provided');
        }

        // Detect geometry type by structure
        if (array_key_exists('x', $geometry) && array_key_exists('y', $geometry)) {
            return self::buildPoint($geometry);
        } elseif (array_key_exists('points', $geometry)) {
            return self::buildMultipoint($geometry);
        } elseif (array_key_exists('paths', $geometry)) {
            return self::buildPolyline($geometry);
        } elseif (array_key_exists('rings', $geometry)) {
            return self::buildPolygon($geometry);
        }

        throw new \InvalidArgumentException('Unable to determine geometry type from provided data');
    }

    /**
     * Build Point from array data
     *
     * @param string|array $data
     * @return \Geodeticca\Geoform\Esrijson\Point
     */
    public static function buildPoint(string|array $data): Point
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return (new Point())->hydrate($data);
    }

    /**
     * Build Multipoint from array data
     *
     * @param string|array $data
     * @return \Geodeticca\Geoform\Esrijson\Multipoint
     */
    public static function buildMultipoint(string|array $data): Multipoint
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return (new Multipoint())->hydrate($data);
    }

    /**
     * Build Polyline from array data
     *
     * @param string|array $data
     * @return \Geodeticca\Geoform\Esrijson\Polyline
     */
    public static function buildPolyline(string|array $data): Polyline
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return (new Polyline())->hydrate($data);
    }

    /**
     * Build Polygon from array data
     *
     * @param string|array $data
     * @return \Geodeticca\Geoform\Esrijson\Polygon
     */
    public static function buildPolygon(string|array $data): Polygon
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return (new Polygon())->hydrate($data);
    }
}
