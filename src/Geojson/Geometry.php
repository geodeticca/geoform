<?php

namespace Geodeticca\Geoform\Geojson;

class Geometry
{
    /**
     * @var string
     */
    public string $type;

    /**
     * @var \Geodeticca\Geoform\Geojson\Coordinate|array
     */
    public Coordinate|array $coordinates;

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        if ($this->type === 'Point') {
            $this->coordinates = self::createCoordinate($coordinates);
        } else {
            $coordinatesBag = [];
            foreach ($coordinates as $coordinate) {
                $coordinatesBag[] = self::createCoordinate($coordinate);
            }

            $this->coordinates = $coordinatesBag;
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

        return $coordinate;
    }
}
