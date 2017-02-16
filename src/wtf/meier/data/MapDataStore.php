<?php
namespace wtf\meier\data;

use GreenCape\Xml\Converter;
use GuzzleHttp\Client;
use wtf\meier\data\constants\NextBikeApi;
use wtf\meier\entity\BikeEntity;
use wtf\meier\exception\RequestFailedException;
use wtf\meier\settings\ApiSettings;

/**
 * Created by PhpStorm.
 * User: meier
 * Date: 16/02/2017
 * Time: 12:46
 */
class MapDataStore
{

    private $apiKey;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var Converter
     */
    private $converterFactory;

    /**
     * @var ApiSettings
     */
    private $apiSettings;

    /**
     * MapDataStore constructor.
     * @param ApiSettings $apiSettings
     * @param Client $httpClient
     * @param XmlConverterFactory $converterFactory
     */
    public function __construct(ApiSettings $apiSettings, Client $httpClient, XmlConverterFactory $converterFactory)
    {
        $this->httpClient = $httpClient;
        $this->converterFactory = $converterFactory;
        $this->apiSettings = $apiSettings;
        $this->apiKey = $apiSettings->getBaseUrl();
    }

    /**
     * @param $stationNumber
     * @return array
     * @throws \Exception
     */
    public function getStationsBikeList($stationNumber)
    {
        $request = $this->httpClient->request('POST', 'getBikeList.xml', [
            'form_params' => [
                'api_key' => $this->apiKey,
                'station' => $stationNumber,
            ]
        ]);
        try {
            $stringResponse = $request->getBody()->getContents();
            $xmlAsArray = $this->converterFactory->createConverter($stringResponse)->data;

            return array_map(function ($bikeAsXmlArray) {
                return BikeEntity::createFromParsedXmlArray($bikeAsXmlArray);
            }, $xmlAsArray[NextBikeApi::XML_ROOT_TAG]);

        } catch (\Exception $exception) {
            // TODO: improve exception rethrowing
            throw new RequestFailedException("Request failed.", $exception);
        }

    }
}