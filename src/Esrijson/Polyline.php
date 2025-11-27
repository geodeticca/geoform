<?php

namespace Geodeticca\Geoform\Esrijson;

class Polyline
{
    /**
     * Array of paths, where each path is an array of points
     * Structure: [[[x1, y1], [x2, y2]], [[x3, y3], [x4, y4]]]
     * For hasZ: [[[x, y, z], ...], ...]
     * For hasM: [[[x, y, m], ...], ...]
     * For both: [[[x, y, z, m], ...], ...]
     *
     * @var array
     */
    public array $paths = [];

    /**
     * Indicates if paths have Z coordinates (elevation)
     *
     * @var bool
     */
    public bool $hasZ = false;

    /**
     * Indicates if paths have M values (measures)
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
     * Add a path to the polyline
     *
     * @param array $path Array of points
     * @return $this
     */
    public function addPath(array $path): self
    {
        $this->paths[] = $path;

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
        if (array_key_exists('paths', $data)) {
            $this->paths = $data['paths'];
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
     * Convert to GeoJSON geometry array
     * Returns LineString for single path, MultiLineString for multiple paths
     *
     * @return array
     */
    public function toGeojson(): array
    {
        // Process paths to filter coordinates
        $processedPaths = array_map(function ($path) {
            return array_map(function ($point) {
                if ($this->hasZ && count($point) >= 3) {
                    // Include Z coordinate
                    return [$point[0], $point[1], $point[2]];
                }
                // Only x and y
                return [$point[0], $point[1]];
            }, $path);
        }, $this->paths);

        // Single path becomes LineString, multiple paths become MultiLineString
        if (count($processedPaths) === 1) {
            return [
                'type' => 'LineString',
                'coordinates' => $processedPaths[0]
            ];
        }

        return [
            'type' => 'MultiLineString',
            'coordinates' => $processedPaths
        ];
    }

    /**
     * Convert to array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'paths' => $this->paths,
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
