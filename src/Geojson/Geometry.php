<?php

namespace Geodeticca\Geoform\Geojson;

class Geometry
{
    /**
     * @var string|null
     */
    public string|null $type = null;

    /**
     * @var \Geodeticca\Geoform\Geojson\Coordinate|\Geodeticca\Geoform\Geojson\CoordinateBag|\Geodeticca\Geoform\Geojson\CoordinateInterior|null
     */
    public Coordinate|CoordinateBag|CoordinateInterior|null $coordinates = null;

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        if ($this->type === 'Point') {
            $this->coordinates = self::createCoordinate($coordinates);
        } elseif ($this->type === 'MultiPoint') {
            $coordinateBag = new CoordinateBag();

            foreach ($coordinates as $coordinate) {
                $coordinateBag->add(self::createCoordinate($coordinate));
            }

            $this->coordinates = $coordinateBag;
        } elseif ($this->type === 'LineString') {
            $coordinateBag = new CoordinateBag();

            foreach ($coordinates as $coordinate) {
                $coordinateBag->add(self::createCoordinate($coordinate));
            }

            $this->coordinates = $coordinateBag;
        } elseif ($this->type === 'MultiLineString') {
            $coordinatePath = new CoordinatePath();

            foreach ($coordinates as $paths) {
                $coordinateBag = new CoordinateBag();

                foreach ($paths as $coordinate) {
                    $coordinateBag->add(self::createCoordinate($coordinate));
                }

                $coordinatePath->add($coordinateBag);
            }

            $this->coordinates = $coordinatePath;
        } elseif ($this->type === 'Polygon') {
            $coordinateRing = new CoordinateRing();

            foreach ($coordinates as $paths) {
                $coordinateBag = new CoordinateBag();

                foreach ($paths as $coordinate) {
                    $coordinateBag->add(self::createCoordinate($coordinate));
                }

                $coordinateRing->add($coordinateBag);
            }

            $this->coordinates = $coordinateRing;
        }

        return $this;
    }

    /**
     * @param array $coordinates
     * @return \Geodeticca\Geoform\Geojson\Coordinate
     */
    public static function createCoordinate(array $coordinates): Coordinate
    {
        $coordinate = new Coordinate();

        if (array_key_exists(0, $coordinates) && array_key_exists(1, $coordinates)) {
            $coordinate->lon = $coordinates[0];
            $coordinate->lat = $coordinates[1];
        }

        if (array_key_exists(2, $coordinates)) {
            $coordinate->z = $coordinates[2];
        }

        return $coordinate;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'coordinates' => $this->coordinates->toArray(),
        ];
    }
}
