<?php

use GuzzleHttp\Exception\TransferException;

class Client
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
        } catch (TransferException $e) {
            error_log($e->getMessage());
        }
    }
}
