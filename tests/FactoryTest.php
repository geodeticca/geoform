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
     * @return string
     */
    private function lineString() : string
    {
        return '{
            "type": "LineString", 
            "coordinates": [
                [102.0, 0.0],
                [103.0, 1.0],
                [104.0, 0.0],
                [105.0, 1.0]
            ]
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

    /**
     * @return array
     */
    private function lineStringFeature() : array
    {
        return json_decode('{
            "type": "Feature",
            "geometry": {
               "type": "LineString",
               "coordinates": [
                    [102.0, 0.0],
                    [103.0, 1.0],
                    [104.0, 0.0],
                    [105.0, 1.0]
                ]
            },
            "properties": {}
        }', true);
    }

    public function testCreatePointFeatureFromGeometry()
    {
        $geometry = $this->point();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = $this->pointFeature();

        $this->assertEquals($feature->toArray(), $expectedFeature);
    }

    public function testCreateLinestringFeatureFromGeometry()
    {
        $geometry = $this->lineString();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = $this->lineStringFeature();

        $this->assertEquals($feature->toArray(), $expectedFeature);
    }
}
