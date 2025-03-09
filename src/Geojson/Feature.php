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
     * @param array $geometry
     * @return $this
     */
    public function setGeometry(array $geometry): self
    {
        $geometry = new Geometry();

        if (array_key_exists('type', $geometry)){
            $geometry->type = $geometry['type'];
        }

        if (array_key_exists('coordinates', $geometry)){
            $geometry->setCoordinates($geometry['coordinates']);
        }

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
}
