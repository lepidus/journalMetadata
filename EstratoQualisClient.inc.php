<?php

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class EstratoQualisClient
{
    public const ENDPOINT = "/qualis";

    public static function getByIssn($issn, $httpClient, $baseUrl)
    {
        try {
            $response = $httpClient->request(
                "GET",
                $baseUrl . self::ENDPOINT,
                [
                    'query' => [
                        'issn' => $issn
                    ]
                ]
            );
            $responseBody = $response->getBody()->getContents();
            $responseArray = json_decode($responseBody, true);

            return $responseArray;
        } catch (ServerException $e) {
            error_log($e->getMessage());
        } catch (ClientException $e) {
            error_log($e->getMessage());
        }
    }
}
