# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP package for converting between geospatial formats, specifically between ArcGIS JSON and GeoJSON. The package provides an object-oriented approach to building and manipulating GeoJSON structures.

**Package Name:** geodeticca/geoform
**PHP Version:** >=8.0
**Namespace:** `Geodeticca\Geoform`

## Development Commands

### Running Tests
```bash
docker exec -it -w $PWD php83 ./vendor/bin/phpunit
```

### Run a Single Test
```bash
docker exec -it -w $PWD php83 ./vendor/bin/phpunit --filter testMethodName
```

### Install Dependencies
```bash
composer install
```

## Architecture

### Core Domain Model

The package uses an object-oriented model to represent GeoJSON structures:

**Geometry Hierarchy:**
- `Coordinate` - Represents a single point with lon/lat properties
- `CoordinateBag` - Collection of Coordinate objects (used for LineString, Polygon, etc.)
- `Geometry` - Wraps coordinates with a geometry type (Point, LineString, Polygon)
  - Point geometries use a single `Coordinate`
  - Other geometries use `CoordinateBag`

**Feature Hierarchy:**
- `Feature` - Contains a Geometry and properties (key-value pairs)
- `FeatureBag` - Collection of Feature objects
- `FeatureCollection` - Top-level GeoJSON object containing multiple features

### Factory Pattern

The `Geojson\Factory` class provides static methods for building GeoJSON objects:
- `buildFeatureFromGeometry(mixed $geom, array $properties = [])` - Creates a Feature from geometry JSON
- `buildFeatureCollectionFromGeometries(array $geoms)` - Creates a FeatureCollection from multiple geometries

Both methods accept geometry data as JSON strings or arrays.

### Key Design Patterns

**Bag Pattern:** FeatureBag and CoordinateBag classes act as simple collections with `add*()` methods and `toArray()` serialization.

**Fluent Interface:** Most setter methods return `$this` for method chaining.

**Array Serialization:** All domain objects implement `toArray()` for converting to GeoJSON-compatible arrays.

## Code Structure

```
src/
├── Geojson/
│   ├── Coordinate.php         - Single coordinate (lon, lat)
│   ├── CoordinateBag.php      - Collection of coordinates
│   ├── Geometry.php           - Geometry with type and coordinates
│   ├── Feature.php            - Feature with geometry and properties
│   ├── FeatureBag.php         - Collection of features
│   ├── FeatureCollection.php  - Top-level GeoJSON structure
│   └── Factory.php            - Static factory methods
└── Transformer/
    └── Geojson.php            - (Currently empty)

tests/
└── FactoryTest.php            - Tests for Factory methods
```

## Important Notes

- The codebase is located within `/var/www/packages/geodeticca-geoform`
- Tests are run inside a Docker container with PHP 8.3
- The Transformer namespace exists but is not yet implemented
- GeoJSON coordinate order is [longitude, latitude] (not lat/lon)
