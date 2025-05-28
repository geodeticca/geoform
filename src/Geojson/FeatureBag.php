<?php

namespace Geodeticca\Geoform\Geojson;

class FeatureBag
{
    /**
     * @var array
     */
    public array $bag = [];

    /**
     * @param \Geodeticca\Geoform\Geojson\Feature $feature
     * @return $this
     */
    public function addFeature(Feature $feature): self
    {
        $this->bag[] = $feature;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item->toArray();
        }, $this->bag);
    }
}
