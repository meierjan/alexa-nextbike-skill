<?php
namespace wtf\meier\data;
;

class NextBikeRepository
{

    /**
     * @var MapDataStore
     */
    private $mapDataStore;


    /**
     * NextBikeRepository constructor.
     * @param MapDataStore $mapDataStore
     */
    public function __construct(MapDataStore $mapDataStore)
    {
        $this->mapDataStore = $mapDataStore;
    }

    /**
     * @param $stationNumber
     * @return array
     */
    public function getBikesForStation($stationNumber)
    {
        return $this->mapDataStore->getStationsBikeList($stationNumber);
    }
}