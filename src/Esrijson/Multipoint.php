<?php

namespace Geodeticca\Geoform\Esrijson;

use Geodeticca\Geoform\Geojson\Geometry as GeojsonGeometry;

class Multipoint extends Geometry
{
    /**
     * Array of points [[x1, y1], [x2, y2], ...]
     * For hasZ: [[x, y, z], ...]
     * For hasM: [[x, y, m], ...]
     * For both: [[x, y, z, m], ...]
     *
     * @var array
     */
    public array $points = [];

    /**
     * Indicates if points have Z coordinates (elevation)
     *
     * @var bool
     */
    public bool $hasZ = false;

    /**
     * Indicates if points have M values (measures)
     *
     * @var bool
     */
    public bool $hasM = false;

    /**
     * Array of point identifiers (optional)
     *
     * @var array|null
     */
    public ?array $ids = null;

    /**
     * Add a point to the multipoint
     *
     * @param array $point
     * @return $this
     */
    public function addPoint(array $point): self
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * Hydrate object from array data
     *
     * @param array $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('points', $data)) {
            $this->points = $data['points'];
        }

        if (array_key_exists('hasZ', $data)) {
            $this->hasZ = $data['hasZ'];
        }

        if (array_key_exists('hasM', $data)) {
            $this->hasM = $data['hasM'];
        }

        if (array_key_exists('ids', $data)) {
            $this->ids = $data['ids'];
        }

        if (array_key_exists('spatialReference', $data)) {
            $spatialReference = new SpatialReference();
            $spatialReference->hydrate($data['spatialReference']);

            $this->spatialReference = $spatialReference;
        }

        return $this;
    }

    /**
     * Convert to GeoJSON
     *
     * @return \Geodeticca\Geoform\Geojson\Geometry
     */
    public function toGeojson(): GeojsonGeometry
    {
        // Filter coordinates based on hasZ and hasM flags
        // GeoJSON supports Z but not M, so we only include x, y, and optionally z
        $coordinates = array_map(function ($point) {
            if ($this->hasZ && count($point) >= 3) {
                // Include Z coordinate
                return [$point[0], $point[1], $point[2]];
            }
            // Only x and y
            return [$point[0], $point[1]];
        }, $this->points);

        $geometry = new GeojsonGeometry();
        $geometry->type = 'MultiPoint';
        $geometry->setCoordinates($coordinates);

        return $geometry;
    }

    /**
     * Convert to array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'points' => $this->points,
        ];

        if ($this->hasZ) {
            $result['hasZ'] = true;
        }

        if ($this->hasM) {
            $result['hasM'] = true;
        }

        if ($this->ids !== null) {
            $result['ids'] = $this->ids;
        }

        if ($this->spatialReference !== null) {
            $result['spatialReference'] = $this->spatialReference->toArray();
        }

        return $result;
    }
}
