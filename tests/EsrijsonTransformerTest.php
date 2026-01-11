<?php

use PHPUnit\Framework\TestCase;

use Geodeticca\Geoform\Transformer\Esrijson as EsrijsonTransformer;
use Geodeticca\Geoform\Geojson\Feature as GeojsonFeature;
use Geodeticca\Geoform\Geojson\FeatureCollection as GeojsonFeatureCollection;

class EsrijsonTransformerTest extends TestCase
{
    public function testConvertEsriPointToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'x' => 30.0,
                'y' => 10.0,
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test Point'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);
        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [30.0, 10.0]
            ],
            'properties' => [
                'name' => 'Test Point'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriPointWithZToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'x' => 30.0,
                'y' => 10.0,
                'z' => 50.0,
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test Point'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [30.0, 10.0, 50.0]
            ],
            'properties' => [
                'name' => 'Test Point'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriMultiPointToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'points' => [
                    [100.0, 0.0],
                    [101.0, 1.0]
                ],
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test MultiPoint'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'MultiPoint',
                'coordinates' => [
                    [100.0, 0.0],
                    [101.0, 1.0]
                ]
            ],
            'properties' => [
                'name' => 'Test MultiPoint'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriPolylineSinglePathToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'paths' => [
                    [
                        [102.0, 0.0],
                        [103.0, 1.0],
                        [104.0, 0.0],
                        [105.0, 1.0]
                    ]
                ],
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test LineString'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'LineString',
                'coordinates' => [
                    [102.0, 0.0],
                    [103.0, 1.0],
                    [104.0, 0.0],
                    [105.0, 1.0]
                ]
            ],
            'properties' => [
                'name' => 'Test LineString'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriPolylineMultiplePathsToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'paths' => [
                    [
                        [100.0, 0.0],
                        [101.0, 1.0]
                    ],
                    [
                        [102.0, 2.0],
                        [103.0, 3.0]
                    ]
                ],
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test LineString'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'MultiLineString',
                'coordinates' => [
                    [
                        [100.0, 0.0],
                        [101.0, 1.0]
                    ],
                    [
                        [102.0, 2.0],
                        [103.0, 3.0]
                    ]
                ]
            ],
            'properties' => [
                'name' => 'Test LineString'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriPolygonToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'rings' => [
                    [
                        [100.0, 0.0],
                        [101.0, 0.0],
                        [101.0, 1.0],
                        [100.0, 1.0],
                        [100.0, 0.0]
                    ]
                ],
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test Polygon'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [100.0, 0.0],
                        [101.0, 0.0],
                        [101.0, 1.0],
                        [100.0, 1.0],
                        [100.0, 0.0]
                    ]
                ]
            ],
            'properties' => [
                'name' => 'Test Polygon'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriPolygonWithMultipleRingsToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'rings' => [
                    [
                        [100.0, 0.0],
                        [101.0, 0.0],
                        [101.0, 1.0],
                        [100.0, 1.0],
                        [100.0, 0.0]
                    ],
                    [
                        [100.2, 0.2],
                        [100.8, 0.2],
                        [100.8, 0.8],
                        [100.2, 0.8],
                        [100.2, 0.2]
                    ]
                ],
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test Polygon'
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [100.0, 0.0],
                        [101.0, 0.0],
                        [101.0, 1.0],
                        [100.0, 1.0],
                        [100.0, 0.0]
                    ],
                    [
                        [100.2, 0.2],
                        [100.8, 0.2],
                        [100.8, 0.8],
                        [100.2, 0.8],
                        [100.2, 0.2]
                    ]
                ]
            ],
            'properties' => [
                'name' => 'Test Polygon'
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriFeatureCollectionToGeojson()
    {
        $esriJson = [
            'features' => [
                [
                    'geometry' => [
                        'x' => 30.0,
                        'y' => 10.0,
                        'spatialReference' => ['wkid' => 4326]
                    ],
                    'attributes' => [
                        'name' => 'Test Point 1'
                    ]
                ],
                [
                    'geometry' => [
                        'x' => 50.0,
                        'y' => 25.0,
                        'spatialReference' => ['wkid' => 4326]
                    ],
                    'attributes' => [
                        'name' => 'Test Point 2'
                    ]
                ]
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeatureCollection::class, $result);
        $resultArray = $result->toArray();

        $expected = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'feature',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [
                            [30.0, 10.0]
                        ]
                    ],
                    'properties' => [
                        'name' => 'Test Point 1'
                    ]
                ],
                [
                    'type' => 'feature',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [
                            [50.0, 25.0]
                        ]
                    ],
                    'properties' => [
                        'name' => 'Test Point 2'
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $resultArray);
    }

    public function testConvertEsriJsonStringToGeojson()
    {
        $esriJsonString = json_encode([
            'geometry' => [
                'x' => 30.0,
                'y' => 10.0,
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => [
                'name' => 'Test Point'
            ]
        ]);

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJsonString);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $this->assertEquals('Feature', $resultArray['type']);
        $this->assertEquals('Test Point', $resultArray['properties']['name']);
    }

    public function testConvertEsriGeometryOnlyToGeojson()
    {
        $esriJson = [
            'x' => 30.0,
            'y' => 10.0,
            'spatialReference' => ['wkid' => 4326]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $this->assertEquals('Feature', $resultArray['type']);
        $this->assertEquals('Point', $resultArray['geometry']['type']);
        $this->assertEquals([30.0, 10.0], $resultArray['geometry']['coordinates']);
    }

    public function testConvertEsriPolylineWithZToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'paths' => [
                    [
                        [102.0, 0.0, 100.0],
                        [103.0, 1.0, 150.0],
                        [104.0, 0.0, 200.0]
                    ]
                ],
                'hasZ' => true,
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => []
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $this->assertEquals('LineString', $resultArray['geometry']['type']);
        $this->assertEquals([102.0, 0.0, 100.0], $resultArray['geometry']['coordinates'][0]);
        $this->assertEquals([103.0, 1.0, 150.0], $resultArray['geometry']['coordinates'][1]);
    }

    public function testConvertEsriPolygonWithZToGeojson()
    {
        $esriJson = [
            'geometry' => [
                'rings' => [
                    [
                        [100.0, 0.0, 10.0],
                        [101.0, 0.0, 20.0],
                        [101.0, 1.0, 30.0],
                        [100.0, 1.0, 40.0],
                        [100.0, 0.0, 10.0]
                    ]
                ],
                'hasZ' => true,
                'spatialReference' => ['wkid' => 4326]
            ],
            'attributes' => []
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $this->assertEquals('Polygon', $resultArray['geometry']['type']);
        $this->assertEquals([100.0, 0.0, 10.0], $resultArray['geometry']['coordinates'][0][0]);
    }

    public function testConvertEsriFeatureSetWithMixedGeometriesToGeojson()
    {
        $esriJson = [
            'features' => [
                [
                    'geometry' => [
                        'x' => 30.0,
                        'y' => 10.0
                    ],
                    'attributes' => [
                        'type' => 'point'
                    ]
                ],
                [
                    'geometry' => [
                        'paths' => [
                            [
                                [102.0, 0.0],
                                [103.0, 1.0]
                            ]
                        ]
                    ],
                    'attributes' => [
                        'type' => 'line'
                    ]
                ],
                [
                    'geometry' => [
                        'rings' => [
                            [
                                [100.0, 0.0],
                                [101.0, 0.0],
                                [101.0, 1.0],
                                [100.0, 1.0],
                                [100.0, 0.0]
                            ]
                        ]
                    ],
                    'attributes' => [
                        'type' => 'polygon'
                    ]
                ]
            ]
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeatureCollection::class, $result);
        $resultArray = $result->toArray();

        $this->assertEquals('FeatureCollection', $resultArray['type']);
        $this->assertCount(3, $resultArray['features']);
        $this->assertEquals('Point', $resultArray['features'][0]['geometry']['type']);
        $this->assertEquals('LineString', $resultArray['features'][1]['geometry']['type']);
        $this->assertEquals('Polygon', $resultArray['features'][2]['geometry']['type']);
    }

    public function testConvertEmptyAttributesToEmptyProperties()
    {
        $esriJson = [
            'geometry' => [
                'x' => 30.0,
                'y' => 10.0
            ],
            'attributes' => []
        ];

        $result = EsrijsonTransformer::esriJsonToGeojson($esriJson);

        $this->assertInstanceOf(GeojsonFeature::class, $result);
        $resultArray = $result->toArray();

        $this->assertIsArray($resultArray['properties']);
        $this->assertEmpty($resultArray['properties']);
    }
}
