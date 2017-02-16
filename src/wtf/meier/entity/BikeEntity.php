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
     * @param boolean $isActive
     * @param int $bikeType
     * @param $state
     */
    private function __construct($name, $isActive, $bikeType, $state)
    {
        $this->name = $name;
        $this->isActive = (boolean)$isActive;
        $this->type = (int)$bikeType;
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }


    function __toString()
    {
        return "BikeEntity(name: {$this->name}, isActive: {$this->isActive}, state: {$this->state}, bikeType: {$this->type})";
    }


    public static function createFromParsedXmlArray($xmlArray)
    {
        return new BikeEntity($xmlArray["@number"], $xmlArray["@active"], (int)$xmlArray["@bike_type"], $xmlArray["@state"]);
    }
}