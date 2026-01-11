<?php

namespace Geodeticca\Geoform\Esrijson;

class FeatureBag
{
    /**
     * @var array
     */
    public array $bag = [];

    /**
     * @param \Geodeticca\Geoform\Esrijson\Feature $feature
     * @return $this
     */
    public function addFeature(Feature $feature): self
    {
        $this->bag[] = $feature;

        return $this;
    }

    /**
     * Convert to GeoJSON
     *
     * @return array
     */
    public function toGeojson(): array
    {
        $geojsons = [];
        foreach ($this->bag as $item) {
            $geojsons[] = $item->toGeojson();
        }

        return $geojsons;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $bagItems = [];
        foreach ($this->bag as $item) {
            $bagItems[] = $item->toArray();
        }

        return $bagItems;
    }
}
