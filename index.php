<?php
use Dotenv\Dotenv;
use wtf\meier\data\MapDataStore;
use wtf\meier\data\NextBikeRepository;
use wtf\meier\data\XmlConverterFactory;
use wtf\meier\settings\ApiSettings;

include('vendor/autoload.php');

// setting up environment stuff
$env = new Dotenv(__DIR__);
$apiSettings = ApiSettings::createFromDotEnv($env);

// load translations
$translations = new i18n();
$translations->init();


$httpClient = new GuzzleHttp\Client([
    'base_uri' => $apiSettings->getBaseUrl()
]);


$xmlConverterFactory = new XmlConverterFactory();
$mapDataStore = new MapDataStore($apiSettings, $httpClient, $xmlConverterFactory);
$nextBikeRepository = new NextBikeRepository($mapDataStore);

$bikesAtStation = $nextBikeRepository->getBikesForStation(4050);

foreach ($bikesAtStation as $bike) {
    echo $bike . "\n";
};