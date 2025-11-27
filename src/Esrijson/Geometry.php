<?php

namespace Geodeticca\Geoform\Esrijson;

abstract class Geometry
{
    /**
     * Spatial reference system
     *
     * @var \Geodeticca\Geoform\Esrijson\SpatialReference|null
     */
    public ?SpatialReference $spatialReference = null;

    /**
     * Set spatial reference
     *
     * @param \Geodeticca\Geoform\Esrijson\SpatialReference $spatialReference
     * @return $this
     */
    public function setSpatialReference(SpatialReference $spatialReference): self
    {
        $this->spatialReference = $spatialReference;

        return $this;
    }
}
