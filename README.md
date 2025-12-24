
# Evolution API PHP SDK

Uma implementação elegante, robusta e de alta performance para integração com a Evolution API v1. Construído sobre os pilares da arquitetura moderna de software, este SDK é agnóstico a frameworks, respeita as normas PSR-17/18 e tira proveito total das funcionalidades do PHP 8.2+.

--------------

# 🏗 Estrutura do Projeto
O pacote segue uma organização rigorosa para garantir manutenibilidade:


## Diretorios
    src/

    ├── Contracts/           # Interfaces e Contratos (Desacoplamento)

    ├── DTOs/                # EvolutionInstance (Objeto de dados unificado)

    ├── Exceptions/         # Hierarquia de erros (Auth, NotFound, etc)

    ├── Providers/          # Integração nativa com Laravel

    └── EvolutionClient.php # O coração do SDK
## 🚀 Instalação

composer require davsonsantos/evolution-api-php
    
## 💻 Uso em PHP Puro (Agnóstico)

Este SDK não te prende a frameworks. Você pode usá-lo com qualquer implementação de cliente HTTP que respeite a PSR-18 (como Guzzle ou Symfony HTTP Client).

    use EvolutionPHP\EvolutionClient;
    use GuzzleHttp\Client as GuzzleClient;
    use GuzzleHttp\Psr7\HttpFactory;

    $evolution = new EvolutionClient(
        baseUrl: 'https://sua-api.com',
        apiKey: 'sua_global_api_key',
        httpClient: new GuzzleClient(),
        requestFactory: new HttpFactory()
    );

    try {
        $instance = $evolution->connect('minha_loja');
        echo "QR Code: " . $instance->qrCodeBase64;
    } catch (\EvolutionPHP\Exceptions\InstanceNotFoundException $e) {
        // Trate instâncias não existentes
    }

## 🍃 Uso com Laravel
O SDK possui Auto-discovery. Basta configurar suas variáveis de ambiente:

1. Adicione ao seu .env:asdasdasd

        EVOLUTION_BASE_URL=https://api.suadominio.com
        EVOLUTION_API_KEY=seu_token_aqui

2) (Opcional) Publique o arquivo de configuração:

        php artisan vendor:publish --tag="evolution-config"

3) Injeção de Dependência em seus Controllers:

        use EvolutionPHP\EvolutionClient;

        public function connect(EvolutionClient $evolution)
        {
            $instance = $evolution->connect('vendas_01');
            return view('qrcode', ['code' => $instance->qrCodeBase64]);
        }

## 🛡 Tratamento de Exceções
Não trabalhamos com arrays de erro ambíguos. O SDK lança exceções de domínio específicas:

    Exceção	                    Causa
    AuthException	            API Key inválida ou expirada (401/403).
    InstanceNotFoundException	A instância solicitada não existe (404).
    EvolutionException	        Erro genérico da API ou falha de comunicação.

## Funcionalidades

🛠 Funcionalidades Implementadas
[x] Conexão e Geração de QR Code (Base64)

[x] Consulta de status de instância

[x] DTO Unificado para respostas de API

[x] Tratamento de erros via Exceções de Domínio

[x] Suporte total a PSR-17 e PSR-18

## ⚖ Licença

The MIT License (MIT). Por favor, veja o [MIT](https://choosealicense.com/licenses/mit/) para mais informações.

