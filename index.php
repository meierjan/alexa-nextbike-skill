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
$alexaResponse = new \Alexa\Response\Response;
$app->any('/', function (Request $request, Response $response) {
    global $nextBikeRepository;
    global $alexaResponse;

    try {

    $jsonDataAsArray = json_decode($request->getBody(), true);
    $alexaRequest = \Alexa\Request\Request::fromData($jsonDataAsArray);

        if ($alexaRequest instanceof IntentRequest) {
            if ($alexaRequest->intentName == "Station") {

                $stationSlot = $alexaRequest->slots;
                $stationNumber = filter_var($stationSlot["station_number"], FILTER_VALIDATE_INT);

                $bikes = $nextBikeRepository->getBikesForStation($stationNumber);
                $bikeCount = count($bikes);

                /** @noinspection PhpUndefinedMethodInspection */
                $alexaResponse
                    ->respond(L::answer_find_bikes($bikeCount, $stationNumber));

                return $response
                    ->withHeader('Content-type', 'application/json')
                    ->write(json_encode($alexaResponse->render()));
            } else {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        $alexaResponse
            ->respond(L::error_intent_not_found);

        return $response
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($alexaResponse->render()));
    }
});

$app->run();
