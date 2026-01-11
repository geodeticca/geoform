<?php

namespace Geodeticca\Geoform\Geojson;

class FeatureCollection
{
    /**
     * @var string
     */
    public string $type = 'FeatureCollection';

    /**
     * @var \Geodeticca\Geoform\Geojson\FeatureBag
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
     * @param \Geodeticca\Geoform\Geojson\Feature $feature
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
                print_r($featureData); exit;
                $feature = new Feature();
                $feature->hydrate($featureData);

                $this->addFeature($feature);
            }
        }
        //print_r($this); exit;
        
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'features' => $this->features->toArray(),
        ];
    }
}
