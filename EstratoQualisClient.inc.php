<?php

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

class EstratoQualisClient
{
    public static function getByIssn($issn, $httpClient)
    {
        try {
            $response = $httpClient->request(
                "GET",
                "http://localhost:8081/qualis",
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
            error_log($e);
        } catch (ClientException $e) {
            error_log($e);
        }
    }
}
