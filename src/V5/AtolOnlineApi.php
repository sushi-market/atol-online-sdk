<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5;

use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Exceptions\AtolOnlineApiV5ErrorException;
use DF\AtolOnline\Exceptions\MissingTokenException;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationResponseDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenRequestDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenResponseDTO;
use DF\AtolOnline\V5\Enums\Operation;
use DF\AtolOnline\V5\Mappers\DocumentRegistrationResponseMapper;
use DF\AtolOnline\V5\Mappers\ErrorResponseMapper;
use DF\AtolOnline\V5\Mappers\GetTokenResponseMapper;
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
    public function __construct(
        private string $login,
        private string $password,
        private string $groupCode,
        private ClientInterface $httpClient,
        public TokenStorage $tokenStorage = new TokenStorage,
        private ?string $source = null,
    ) {}

    public function auth(?string $login = null, ?string $password = null, ?string $source = null): static
    {
        $accessToken = new AccessToken(
            value: static::getToken(
                requestDTO: new GetTokenRequestDTO(
                    login: $login ?? $this->login,
                    pass: $password ?? $this->password,
                    source: $source ?? $this->source,
                ),
            )->token
        );

        $this->tokenStorage->token = $accessToken;

        return $this;
    }

    public function getToken(GetTokenRequestDTO $requestDTO): GetTokenResponseDTO
    {
        return GetTokenResponseMapper::fromJsonResponse(
            response: $this->send(
                request: new GetTokenRequest($requestDTO),
            ),
        );
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
        return DocumentRegistrationResponseMapper::fromJsonResponse(
            response: $this->send(
                request: new DocumentRegistrationRequest(
                    groupCode: $this->groupCode,
                    operation: Operation::SELL,
                    requestDTO: $requestDTO,
                ),
            ),
        );
    }

    private function send(ApiRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();
        $method = $request->getMethod()->value;
        $options = [
            RequestOptions::HEADERS => $request->getHeaders(),
        ];

        if ($request->getBody() !== null) {
            $options[RequestOptions::JSON] = $request->getBody();
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
            $errorResponseDTO = ErrorResponseMapper::fromJsonResponse(
                response: $e->getResponse(),
            );

            throw new AtolOnlineApiV5ErrorException($errorResponseDTO);
        }

        return $response;
    }
}
