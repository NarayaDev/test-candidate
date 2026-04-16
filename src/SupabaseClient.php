<?php

namespace SupabaseExample;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SupabaseClient
{
    private Client $client;

    public function __construct(string $url, string $apiKey)
    {
        $baseUri = rtrim($url, '/') . '/rest/v1/';
        $this->client = new Client([
            'base_uri' => $baseUri,
            'headers' => [
                'apikey' => $apiKey,
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function fetchTable(string $table, array $query = []): array
    {
        $query = array_merge(['select' => '*', 'limit' => 5], $query);
        return $this->request('GET', $table, ['query' => $query]);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, mixed> $options
     * @return array
     * @throws \RuntimeException
     */
    public function request(string $method, string $path, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $path, $options);
            $body = (string) $response->getBody();
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            return is_array($data) ? $data : [];
        } catch (GuzzleException $exception) {
            throw new \RuntimeException('Supabase request failed: ' . $exception->getMessage());
        }
    }
}
