<?php
/**
 * Created by PhpStorm.
 * User: meier
 * Date: 16/02/2017
 * Time: 14:32
 */

namespace wtf\meier\data;;

use GreenCape\Xml\Converter;

class XmlConverterFactory
{

    /**
     * XmlConverterFactory constructor.
     */
    public function __construct()
    {
    }

    public function createConverter($xml) {
        return new Converter($xml);
    }
}