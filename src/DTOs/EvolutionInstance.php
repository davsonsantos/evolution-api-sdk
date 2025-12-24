<?php

namespace EvolutionPHP\DTOs;

/**
 * Representação unificada de uma Instância na Evolution API.
 * Substitui InstanceResponse e QrCodeResponse.
 */
readonly class EvolutionInstance
{
    public function __construct(
        public string $name,
        public string $status,
        public ?string $hash = null,
        public ?string $qrCodeBase64 = null,
        public ?string $pairingCode = null,
        public int $qrCodeCount = 0,
    ) {}

    /**
     * Factory method para mapear diferentes formatos de resposta da API
     */
    public static function fromArray(array $data): self
    {
        // A API às vezes retorna os dados aninhados em 'instance' ou na raiz
        $instance = $data['instance'] ?? $data;
        $qrcode = $data['qrcode'] ?? [];

        return new self(
            name: $instance['instanceName'] ?? $instance['name'] ?? 'unknown',
            status: $instance['status'] ?? 'disconnected',
            hash: $instance['instanceId'] ?? null,
            qrCodeBase64: $qrcode['base64'] ?? $data['base64'] ?? null,
            pairingCode: $qrcode['code'] ?? $data['code'] ?? null,
            qrCodeCount: (int) ($qrcode['count'] ?? $data['count'] ?? 0)
        );
    }
}