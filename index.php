<?php
use Alexa\Request\IntentRequest;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
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


$httpClient = new Client([
    'base_uri' => $apiSettings->getBaseUrl()
]);


$xmlConverterFactory = new XmlConverterFactory();
$mapDataStore = new MapDataStore($apiSettings, $httpClient, $xmlConverterFactory);
$nextBikeRepository = new NextBikeRepository($mapDataStore);

$app = new App;

$app->any('/', function (Request $request, Response $response) {

    $jsonDataAsArray = json_decode($request->getBody(), true);
    $alexaRequest = \Alexa\Request\Request::fromData($jsonDataAsArray);

    if ($alexaRequest instanceof IntentRequest) {
        $alexaResponse = new \Alexa\Response\Response;

        $alexaResponse
            ->respond('Cooool. I\'ll lower the temperature a bit for you!')
            ->withCard('Temperature decreased by 2 degrees');

        return $response
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($alexaResponse->render()));
    } else {
        throw new Exception();
    }
});
$app->run();
