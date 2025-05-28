<?php

namespace Geodeticca\Geoform\Geojson;

class Geometry
{
    /**
     * @var string
     */
    public string $type;

    /**
     * @var \Geodeticca\Geoform\Geojson\Coordinate|\Geodeticca\Geoform\Geojson\CoordinateBag
     */
    public Coordinate|CoordinateBag $coordinates;

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        if ($this->type === 'Point') {
            $this->coordinates = self::createCoordinate($coordinates);
        } else {
            $coordinatesBag = new CoordinateBag();
            foreach ($coordinates as $coordinate) {
                $coordinatesBag->addCoordinate(self::createCoordinate($coordinate));
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
