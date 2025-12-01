<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5;

use BackedEnum;
use Brick\JsonMapper\JsonMapper;
use Brick\JsonMapper\OnMissingProperties;
use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Exceptions\AtolOnlineApiV5ErrorException;
use DF\AtolOnline\Exceptions\MissingTokenException;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\DocumentInfo\DocumentInfoRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentInfo\DocumentInfoResponseDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationResponseDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenRequestDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenResponseDTO;
use DF\AtolOnline\V5\DTO\Shared\ErrorResponseDTO;
use DF\AtolOnline\V5\Enums\Operation;
use DF\AtolOnline\V5\Requests\DocumentInfoRequest;
use DF\AtolOnline\V5\Requests\DocumentRegistrationRequest;
use DF\AtolOnline\V5\Requests\GetTokenRequest;
use DF\AtolOnline\V5\Storage\TokenStorage;
use DF\AtolOnline\V5\ValueObjects\AccessToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

readonly class AtolOnlineApi
{
    private JsonMapper $mapper;

    public function __construct(
        private string $login,
        private string $password,
        private string $groupCode,
        private ClientInterface $httpClient,
        public TokenStorage $tokenStorage = new TokenStorage,
        private ?string $source = null,
    ) {
        $this->mapper = new JsonMapper(
            onMissingProperties: OnMissingProperties::SET_DEFAULT,
        );
    }

    public function auth(): static
    {
        $responseDTO = $this->getToken(
            requestDTO: new GetTokenRequestDTO(
                login: $this->login,
                pass: $this->password,
                source: $this->source,
            ),
        );

        $this->tokenStorage->token = new AccessToken(
            value: $responseDTO->token,
        );

        return $this;
    }

    public function getToken(GetTokenRequestDTO $requestDTO): GetTokenResponseDTO
    {
        $json = $this->send(new GetTokenRequest(
            requestDTO: $requestDTO,
        ))->getBody()->getContents();

        return $this->mapper->map($json, GetTokenResponseDTO::class);
    }

    public function sell(DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        return $this->documentRegistration(Operation::SELL, $requestDTO);
    }

    public function sellRefund(DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        return $this->documentRegistration(Operation::SELL_REFUND, $requestDTO);
    }

    public function buy(DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        return $this->documentRegistration(Operation::BUY, $requestDTO);
    }

    public function buyRefund(DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        return $this->documentRegistration(Operation::BUY_REFUND, $requestDTO);
    }

    private function documentRegistration(Operation $operation, DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        $json = $this->send(new DocumentRegistrationRequest(
            groupCode: $this->groupCode,
            operation: $operation,
            requestDTO: $requestDTO,
        ))->getBody()->getContents();

        return $this->mapper->map($json, DocumentRegistrationResponseDTO::class);
    }

    public function documentInfo(DocumentInfoRequestDTO $requestDTO): DocumentInfoResponseDTO
    {
        $json = $this->send(new DocumentInfoRequest(
            groupCode: $this->groupCode,
            uuid: $requestDTO->uuid,
        ))->getBody()->getContents();

        return $this->mapper->map($json, DocumentInfoResponseDTO::class);
    }

    private function send(ApiRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();
        $method = $request->getMethod()->value;
        $options = [
            RequestOptions::HEADERS => $request->getHeaders(),
        ];

        if ($request->getBody() !== null) {
            $options[RequestOptions::JSON] = $this->serializeJsonToArray($request->getBody());
        }

        if ($request->getAuthType() === HttpAuthType::API_KEY) {
            if (empty($this->tokenStorage->token)) {
                throw new MissingTokenException;
            }

            $options[RequestOptions::HEADERS] = array_merge($options[RequestOptions::HEADERS], [
                'Token' => $this->tokenStorage->token->value,
            ]);
        }

        try {
            $response = $this->httpClient->request($method, $uri, $options);
        } catch (BadResponseException $e) {
            $json = $e->getResponse()->getBody()->getContents();

            $errorResponseDTO = $this->mapper->map($json, ErrorResponseDTO::class);

            throw new AtolOnlineApiV5ErrorException($errorResponseDTO);
        }

        return $response;
    }

    private function serializeJsonToArray(object|array $json): array
    {
        $result = (array) $json;

        foreach ($result as $key => $item) {
            $result[$key] = match (true) {
                $item instanceof BackedEnum => $item->value,
                is_object($item), is_array($item) => $this->serializeJsonToArray($item),
                default => $item,
            };
        }

        return array_filter($result, fn ($value) => $value !== null);
    }
}
