<?php

namespace EvolutionPHP;

use EvolutionPHP\Contracts\EvolutionClientInterface;
use EvolutionPHP\DTOs\EvolutionInstance;
use EvolutionPHP\DTOs\InstanceResponse;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use EvolutionPHP\Exceptions\EvolutionException;
use EvolutionPHP\Exceptions\InstanceNotFoundException;
use EvolutionPHP\Exceptions\AuthException;
use Psr\Http\Message\ResponseInterface;

class EvolutionClient implements EvolutionClientInterface
{
    public function __construct(
        private string $baseUrl,
        private string $apiKey,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory
    ) {}

    /**
     * Gera o QR Code ou recupera o estado da conexão.
     */
    public function connect(string $instanceName): EvolutionInstance
    {
        $data = $this->request('GET', "/instance/connect/{$instanceName}");
        return EvolutionInstance::fromArray($data);
    }

    /**
     * Verifica o estado atual da instância (Se está aberta, fechada ou conectada).
     */
    public function getInstance(string $instanceName): array
    {
        return $this->request('GET', "/instance/fetchInstances?instanceName={$instanceName}");
    }

    /**
     * Método auxiliar para realizar requisições HTTP autenticadas.
     */
    private function request(string $method, string $path, ?array $body = null): array
    {
        $url = rtrim($this->baseUrl, '/') . $path;
        $request = $this->requestFactory->createRequest($method, $url)
            ->withHeader('apikey', $this->apiKey)
            ->withHeader('Content-Type', 'application/json');

        if ($body) {
            $request->getBody()->write(json_encode($body));
        }

        $response = $this->httpClient->sendRequest($request);

        // Se o status não for 2xx, tratamos o erro
        if ($response->getStatusCode() >= 400) {
            $this->handleErrorResponse($response);
        }

        $contents = $response->getBody()->getContents();
        return json_decode($contents, true) ?? [];
    }

    public function createInstance(string $name): EvolutionInstance
    {
        $request = $this->requestFactory->createRequest('POST', "{$this->baseUrl}/instance/create")
            ->withHeader('apikey', $this->apiKey)
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode(['instanceName' => $name]));

        $response = $this->httpClient->sendRequest($request);
        $data = json_decode($response->getBody()->getContents(), true);

        return EvolutionInstance::fromArray($data);
    }

    public function getInstanceStatus(string $name): array
    {
        // Lógica similar para buscar status...
        return [];
    }

    /**
     * Analisa o status code e lança a exceção de domínio apropriada.
     */
    private function handleErrorResponse(ResponseInterface $response): void
    {
        $status = $response->getStatusCode();
        $data = json_decode($response->getBody()->getContents(), true);
        $message = $data['message'] ?? 'Erro desconhecido na Evolution API';

        throw match ($status) {
            401, 403 => new AuthException("Falha de autenticação: {$message}", $status),
            404      => new InstanceNotFoundException("Instância não encontrada: {$message}", $status),
            default  => new EvolutionException("Erro na API Evolution: {$message}", $status),
        };
    }
}
