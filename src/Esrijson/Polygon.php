<?php

namespace Geodeticca\Geoform\Esrijson;

use Geodeticca\Geoform\Geojson\Geometry as GeojsonGeometry;

class Polygon extends Geometry
{
    /**
     * Array of rings, where each ring is an array of points
     * Structure: [[[x1, y1], [x2, y2], [x1, y1]], [[x3, y3], ...]]
     * First and last point in each ring must be identical (closed)
     * Exterior rings are clockwise, holes are counterclockwise
     * For hasZ: [[[x, y, z], ...], ...]
     * For hasM: [[[x, y, m], ...], ...]
     * For both: [[[x, y, z, m], ...], ...]
     *
     * @var array
     */
    public array $rings = [];

    /**
     * Indicates if rings have Z coordinates (elevation)
     *
     * @var bool
     */
    public bool $hasZ = false;

    /**
     * Indicates if rings have M values (measures)
     *
     * @var bool
     */
    public bool $hasM = false;

    /**
     * Nested array of point identifiers (optional)
     *
     * @var array|null
     */
    public ?array $ids = null;

    /**
     * Add a ring to the polygon
     *
     * @param array $ring Array of points (must be closed)
     * @return $this
     */
    public function addRing(array $ring): self
    {
        $this->rings[] = $ring;

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
        if (array_key_exists('rings', $data)) {
            $this->rings = $data['rings'];
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
        // Process rings to filter coordinates
        $processedRings = array_map(function ($ring) {
            return array_map(function ($point) {
                if ($this->hasZ && count($point) >= 3) {
                    // Include Z coordinate
                    return [$point[0], $point[1], $point[2]];
                }
                // Only x and y
                return [$point[0], $point[1]];
            }, $ring);
        }, $this->rings);

        $geometry = new GeojsonGeometry();
        $geometry->type = 'Polygon';

        $geometry->setCoordinates($processedRings);

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
            'rings' => $this->rings,
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
