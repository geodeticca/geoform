<?php

namespace Geodeticca\Geoform\Esrijson;

class SpatialReference
{
    /**
     * Well-known ID (original assignment)
     *
     * @var int|null
     */
    public ?int $wkid = null;

    /**
     * Latest well-known ID
     *
     * @var int|null
     */
    public ?int $latestWkid = null;

    /**
     * Vertical coordinate system WKID
     *
     * @var int|null
     */
    public ?int $vcsWkid = null;

    /**
     * Latest vertical coordinate system WKID
     *
     * @var int|null
     */
    public ?int $latestVcsWkid = null;

    /**
     * Well-known text definition
     *
     * @var string|null
     */
    public ?string $wkt = null;

    /**
     * Hydrate object from array data
     *
     * @param array $data
     * @return $this
     */
    public function hydrate(array $data): self
    {
        if (array_key_exists('wkid', $data)) {
            $this->wkid = $data['wkid'];
        }

        if (array_key_exists('latestWkid', $data)) {
            $this->latestWkid = $data['latestWkid'];
        }

        if (array_key_exists('vcsWkid', $data)) {
            $this->vcsWkid = $data['vcsWkid'];
        }

        if (array_key_exists('latestVcsWkid', $data)) {
            $this->latestVcsWkid = $data['latestVcsWkid'];
        }

        if (array_key_exists('wkt', $data)) {
            $this->wkt = $data['wkt'];
        }

        return $this;
    }

    /**
     * Convert to array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->wkid !== null) {
            $result['wkid'] = $this->wkid;
        }

        if ($this->latestWkid !== null) {
            $result['latestWkid'] = $this->latestWkid;
        }

        if ($this->vcsWkid !== null) {
            $result['vcsWkid'] = $this->vcsWkid;
        }

        if ($this->latestVcsWkid !== null) {
            $result['latestVcsWkid'] = $this->latestVcsWkid;
        }

        if ($this->wkt !== null) {
            $result['wkt'] = $this->wkt;
        }

        return $result;
    }
}
