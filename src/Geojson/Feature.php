<?php

namespace Geodeticca\Geoform\Geojson;

class Feature
{
    /**
     * @var string
     */
    public string $type = 'Feature';

    /**
     * @var \Geodeticca\Geoform\Geojson\Geometry|null
     */
    public Geometry|null $geometry = null;

    /**
     * @var array
     */
    public array $properties = [];

    /**
     * @param array $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('properties', $data)) {
            $this->setProperties($data['properties']);
        }

        if (array_key_exists('geometry', $data)) {
            $this->setGeometry($data['geometry']);
        }

        return $this;
    }

    /**
     * @param array $geom
     * @return $this
     */
    public function setGeometry(array $geom): self
    {
        $geometry = new Geometry();

        if (array_key_exists('type', $geom)) {
            $geometry->type = $geom['type'];
        }

        if (array_key_exists('coordinates', $geom)) {
            //print_r($geom['coordinates']);
            $geometry->setCoordinates($geom['coordinates']);
        }

        $this->geometry = $geometry;

        return $this;
    }

    /**
     * @param string $title
     * @param mixed $value
     * @return $this
     */
    public function addProperty(string $title, $value): self
    {
        $this->properties[$title] = $value;

        return $this;
    }

    /**
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties): self
    {
        foreach ($properties as $propertyTitle => $propertyValue) {
            $this->addProperty($propertyTitle, $propertyValue);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'geometry' => $this->geometry->toArray(),
            'properties' => $this->properties,
        ];
    }
}
