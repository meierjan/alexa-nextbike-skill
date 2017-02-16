<?php
namespace wtf\meier\entity;

/**
 * Created by PhpStorm.
 * User: meier
 * Date: 16/02/2017
 * Time: 15:14
 */
class BikeEntity
{
    private $name;
    private $isActive;
    private $state;
    private $type;

    /**
     * BikeEntity constructor.
     * @param $name
     * @param $isActive
     * @param $bikeType
     * @param $state
     */
    private function __construct($name, $isActive, $bikeType, $state)
    {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->state = $state;
        $this->type = $bikeType;
    }

    function __toString()
    {
        return "BikeEntity(name: {$this->name}, isActive: {$this->isActive}, state: {$this->state}, bikeType: {$this->type})";
    }


    public static function createFromArray($xmlArray)
    {
        return new BikeEntity($xmlArray["@number"], (boolean)$xmlArray["@active"], (int)$xmlArray["@bike_type"], $xmlArray["@state"]);
    }
}