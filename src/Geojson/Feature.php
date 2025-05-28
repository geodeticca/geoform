<?php

namespace Geodeticca\Geoform\Geojson;

class Feature
{
    /**
     * @var string
     */
    public string $type = 'Feature';

    /**
     * @var \Geodeticca\Geoform\Geojson\Geometry
     */
    public Geometry $geometry;

    /**
     * @var array
     */
    public array $properties = [];

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
