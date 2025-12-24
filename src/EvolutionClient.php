<?php
namespace EvolutionPHP;

use EvolutionPHP\Contracts\EvolutionClientInterface;
use EvolutionPHP\DTOs\InstanceResponse;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class EvolutionClient implements EvolutionClientInterface 
{
    public function __construct(
        private string $baseUrl,
        private string $apiKey,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory
    ) {}

    public function createInstance(string $name): InstanceResponse 
    {
        $request = $this->requestFactory->createRequest('POST', "{$this->baseUrl}/instance/create")
            ->withHeader('apikey', $this->apiKey)
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode(['instanceName' => $name]));
        
        $response = $this->httpClient->sendRequest($request);
        $data = json_decode($response->getBody()->getContents(), true);

        return InstanceResponse::fromArray($data);
    }

    public function getInstanceStatus(string $name): array {
        // Lógica similar para buscar status...
        return [];
    }
}