<?php

namespace Geodeticca\Geoform\Esrijson;

use Geodeticca\Geoform\Geojson\Geometry as GeojsonGeometry;

class Point extends Geometry
{
    /**
     * X coordinate (longitude)
     *
     * @var float|null
     */
    public ?float $x = null;

    /**
     * Y coordinate (latitude)
     *
     * @var float|null
     */
    public ?float $y = null;

    /**
     * Z coordinate (elevation)
     *
     * @var float|null
     */
    public ?float $z = null;

    /**
     * M value (measure)
     *
     * @var float|null
     */
    public ?float $m = null;

    /**
     * Point identifier
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Hydrate object from array data
     *
     * @param array $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('x', $data)) {
            $this->x = $data['x'];
        }

        if (array_key_exists('y', $data)) {
            $this->y = $data['y'];
        }

        if (array_key_exists('z', $data)) {
            $this->z = $data['z'];
        }

        if (array_key_exists('m', $data)) {
            $this->m = $data['m'];
        }

        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
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
        $coordinates = [$this->x, $this->y];

        // Add Z coordinate (elevation) if present
        if ($this->z !== null) {
            $coordinates[] = $this->z;
        }

        $geometry = new GeojsonGeometry();
        $geometry->setCoordinates([
            'type' => 'Point',
            'coordinates' => $coordinates
        ]);

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
            'x' => $this->x,
            'y' => $this->y,
        ];

        if ($this->z !== null) {
            $result['z'] = $this->z;
        }

        if ($this->m !== null) {
            $result['m'] = $this->m;
        }

        if ($this->id !== null) {
            $result['id'] = $this->id;
        }

        if ($this->spatialReference !== null) {
            $result['spatialReference'] = $this->spatialReference->toArray();
        }

        return $result;
    }
}
