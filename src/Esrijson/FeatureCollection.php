<?php

namespace Geodeticca\Geoform\Esrijson;

use Geodeticca\Geoform\Geojson\FeatureCollection as GeojsonFeatureCollection;

class FeatureCollection
{
    /**
     * @var \Geodeticca\Geoform\Esrijson\FeatureBag
     */
    public FeatureBag $features;

    /**
     * FeatureCollection constructor.
     */
    public function __construct()
    {
        $this->features = new FeatureBag();
    }

    /**
     * @param \Geodeticca\Geoform\Esrijson\Feature $feature
     * @return $this
     */
    public function addFeature(Feature $feature): self
    {
        $this->features->addFeature($feature);

        return $this;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('features', $data)) {
            $featuresData = $data['features'];

            foreach ($featuresData as $featureData) {
                $feature = new Feature();
                $feature->hydrate($featureData);

                $this->addFeature($feature);
            }
        }

        return $this;
    }

    /**
     * Convert to GeoJSON
     *
     * @return \Geodeticca\Geoform\Geojson\FeatureCollection
     */
    public function toGeojson(): GeojsonFeatureCollection
    {
        $geojson = new GeojsonFeatureCollection();

        $geojson->setFeatures($this->features->toGeojson());

        return $geojson;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'features' => $this->features->toArray(),
        ];
    }
}
