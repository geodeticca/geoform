<?php

use PHPUnit\Framework\TestCase;

use Geodeticca\Geoform\Geojson\Factory as GeojsonFactory;

class FactoryTest extends TestCase
{
    /**
     * @return string
     */
    private function point() : string
    {
        return '{
            "type": "Point", 
            "coordinates": [30.0, 10.0]
        }';
    }

    /**
     * @return array
     */
    private function pointFeature() : array
    {
        return json_decode('{
            "type": "Feature",
            "geometry": {
               "type": "Point",
               "coordinates": [30.0, 10.0]
            },
            "properties": {}
        }', true);
    }

    public function testCreatePointFeatureFromGeometry()
    {
        $geometry = $this->point();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = $this->pointFeature();

        $this->assertEquals($feature, $expectedFeature);
    }
}
