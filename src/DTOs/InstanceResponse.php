<?php
namespace EvolutionPHP\DTOs;

readonly class InstanceResponse {
    public function __construct(
        public string $instanceName,
        public string $status,
        public ?string $qrcode = null,
        public ?string $pairingCode = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            instanceName: $data['instance']['instanceName'] ?? 'unknown',
            status: $data['instance']['status'] ?? 'disconnected',
            qrcode: $data['qrcode']['base64'] ?? null
        );
    }
}