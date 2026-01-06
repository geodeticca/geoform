<?php

use PHPUnit\Framework\TestCase;

use Geodeticca\Geoform\Geojson\Factory as GeojsonFactory;

class FactoryTest extends TestCase
{
    /**
     * @return string
     */
    private function point(): string
    {
        return '{
            "type": "Point", 
            "coordinates": [30.0, 10.0]
        }';
    }

    /**
     * @return string
     */
    private function lineString(): string
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
     * @return string
     */
    private function polygon(): string
    {
        return '{
            "type": "Polygon", 
            "coordinates": [
                [100.0, 0.0],
                [101.0, 0.0],
                [101.0, 1.0],
                [100.0, 1.0],
                [100.0, 0.0]
            ]
        }';
    }

    /**
     * @param string $type
     * @return string
     * @throws Exception
     */
    private function feature(string $type): string
    {
        $geojson = match ($type) {
            'point', 'lineString', 'polygon' => $this->{$type}(),
            default => throw new \Exception('Unsupported geometry type.'),
        };

        return '{
            "type": "Feature",
            "geometry": '. $geojson .',
            "properties": {}
        }';
    }

    /**
     * @return string
     * @throws Exception
     */
    private function featureCollection(): string
    {
        $geojsons = implode(',', [
            $this->feature('point'),
            $this->feature('lineString'),
            $this->feature('polygon'),
        ]);

        return '{
            "type": "FeatureCollection",
            "features": [
                '. $geojsons .'
            ]
        }';
    }

    public function testCreatePointFeatureFromGeometry()
    {
        $geometry = $this->point();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = json_decode($this->feature('point'), true);

        $this->assertEquals($feature->toArray(), $expectedFeature);
    }

    public function testCreateLineStringFeatureFromGeometry()
    {
        $geometry = $this->lineString();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = json_decode($this->feature('lineString'), true);

        $this->assertEquals($feature->toArray(), $expectedFeature);
    }

    public function testCreatePolygonFeatureFromGeometry()
    {
        $geometry = $this->polygon();

        $feature = GeojsonFactory::buildFeatureFromGeometry($geometry);
        $expectedFeature = json_decode($this->feature('polygon'), true);

        $this->assertEquals($feature->toArray(), $expectedFeature);
    }

    public function testCreateFeatureCollectionFromGeometries()
    {
        $pointGeometry = $this->point();
        $lineStringGeometry = $this->lineString();
        $polygonGeometry = $this->polygon();

        $geometries = [
            $pointGeometry,
            $lineStringGeometry,
            $polygonGeometry,
        ];

        $featureCollection = GeojsonFactory::buildFeatureCollectionFromGeometries($geometries);
        $expectedFeatureCollection = json_decode($this->featureCollection(), true);

        $this->assertEquals($featureCollection->toArray(), $expectedFeatureCollection);
    }
}
