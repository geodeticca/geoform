<?php

namespace Geodeticca\Geoform\Esrijson;

use Geodeticca\Geoform\Geojson\Feature as GeojsonFeature;

class Feature
{
    /**
     * @var \Geodeticca\Geoform\Esrijson\Geometry
     */
    public Geometry $geometry;

    /**
     * @var array
     */
    public array $attributes = [];

    /**
     * @param array $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('attributes', $data)) {
            $this->setProperties($data['attributes']);
        }

        if (array_key_exists('geometry', $data)) {
            $this->setGeometry($data['geometry']);
        }

        return $this;
    }

    /**
     * Convert to GeoJSON
     *
     * @return \Geodeticca\Geoform\Geojson\Feature
     */
    public function toGeojson(): GeojsonFeature
    {
        $geojson = new GeojsonFeature();

        $geojson->hydrate([
            'geometry' => $this->geometry->toGeojson()->toArray(),
            'properties' => $this->attributes,
        ]);

        return $geojson;
    }

    /**
     * @param array $geometry
     * @return $this
     */
    public function setGeometry(array $geometry): self
    {
        // Detect geometry type by structure
        if (array_key_exists('x', $geometry) && array_key_exists('y', $geometry)) {
            $this->geometry = $this->buildPoint($geometry);
        } elseif (array_key_exists('points', $geometry)) {
            $this->geometry = $this->buildMultipoint($geometry);
        } elseif (array_key_exists('paths', $geometry)) {
            $this->geometry = $this->buildPolyline($geometry);
        } elseif (array_key_exists('rings', $geometry)) {
            $this->geometry = $this->buildPolygon($geometry);
        }

        return $this;
    }

    /**
     * Build Point from array data
     *
     * @param string|array $data
     * @return \Geodeticca\Geoform\Esrijson\Geometry|\Geodeticca\Geoform\Esrijson\Point
     */
    public function buildPoint(string|array $data): Geometry|Point
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
     * @return \Geodeticca\Geoform\Esrijson\Geometry|\Geodeticca\Geoform\Esrijson\Multipoint
     */
    public function buildMultipoint(string|array $data): Geometry|Multipoint
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
     * @return \Geodeticca\Geoform\Esrijson\Geometry|\Geodeticca\Geoform\Esrijson\Polyline
     */
    public function buildPolyline(string|array $data): Geometry|Polyline
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
     * @return \Geodeticca\Geoform\Esrijson\Geometry|\Geodeticca\Geoform\Esrijson\Polygon
     */
    public function buildPolygon(string|array $data): Geometry|Polygon
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return (new Polygon())->hydrate($data);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @return $this
     */
    public function addAttribute(string $title, $value): self
    {
        $this->attributes[$title] = $value;

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $propertyTitle => $propertyValue) {
            $this->addAttribute($propertyTitle, $propertyValue);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'geometry' => $this->geometry->toArray(),
            'attributes' => $this->attributes,
        ];
    }
}
