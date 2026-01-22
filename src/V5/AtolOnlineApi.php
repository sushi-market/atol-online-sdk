<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5;

use BackedEnum;
use Brick\JsonMapper\JsonMapper;
use Brick\JsonMapper\OnExtraProperties;
use Brick\JsonMapper\OnMissingProperties;
use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Exceptions\AtolOnlineApiV5ErrorException;
use DF\AtolOnline\Exceptions\MissingTokenException;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\DocumentCorrection\DocumentCorrectionRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentCorrection\DocumentCorrectionResponseDTO;
use DF\AtolOnline\V5\DTO\DocumentInfo\DocumentInfoRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentInfo\DocumentInfoResponseDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationRequestDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationResponseDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenRequestDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenResponseDTO;
use DF\AtolOnline\V5\DTO\Shared\ErrorResponseDTO;
use DF\AtolOnline\V5\Enums\Operation;
use DF\AtolOnline\V5\Requests\DocumentCorrectionRequest;
use DF\AtolOnline\V5\Requests\DocumentInfoRequest;
use DF\AtolOnline\V5\Requests\DocumentRegistrationRequest;
use DF\AtolOnline\V5\Requests\GetTokenRequest;
use DF\AtolOnline\V5\Storage\TokenStorage;
use DF\AtolOnline\V5\ValueObjects\AccessToken;
use DF\AtolOnline\V5\ValueObjects\Credentials;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

readonly final class AtolOnlineApi
{
    private JsonMapper $mapper;
    private ClientInterface $httpClient;
    private TokenStorage $tokenStorage;

    public function __construct(
        private Credentials $credentials,
        ?AccessToken $accessToken = null,
        ?ClientInterface $httpClient = null,
    ) {
        $this->httpClient = $httpClient ?? new Client([
            'base_uri' => 'https://online.atol.ru/possystem/v5/',
        ]);

        $this->tokenStorage = new TokenStorage(
            token: $accessToken
        );

        $this->mapper = new JsonMapper(
            onExtraProperties: OnExtraProperties::IGNORE,
            onMissingProperties: OnMissingProperties::SET_DEFAULT,
        );
    }

    public function auth(?string $token = null): AccessToken
    {
        $token ??= $this->getToken(
            requestDTO: new GetTokenRequestDTO(
                login: $this->credentials->login,
                pass: $this->credentials->password,
            ),
        )->token;

        $this->tokenStorage->token = new AccessToken(
            value: $token,
        );

        return $this->tokenStorage->token;
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

    public function sellCorrection(DocumentCorrectionRequestDTO $requestDTO): DocumentCorrectionResponseDTO
    {
        return $this->documentCorrection(Operation::SELL_CORRECTION, $requestDTO);
    }

    public function sellRefundCorrection(DocumentCorrectionRequestDTO $requestDTO): DocumentCorrectionResponseDTO
    {
        return $this->documentCorrection(Operation::SELL_REFUND_CORRECTION, $requestDTO);
    }

    public function buyCorrection(DocumentCorrectionRequestDTO $requestDTO): DocumentCorrectionResponseDTO
    {
        return $this->documentCorrection(Operation::BUY_CORRECTION, $requestDTO);
    }

    public function buyRefundCorrection(DocumentCorrectionRequestDTO $requestDTO): DocumentCorrectionResponseDTO
    {
        return $this->documentCorrection(Operation::BUY_REFUND_CORRECTION, $requestDTO);
    }

    private function documentRegistration(Operation $operation, DocumentRegistrationRequestDTO $requestDTO): DocumentRegistrationResponseDTO
    {
        $json = $this->send(new DocumentRegistrationRequest(
            groupCode: $this->credentials->groupCode,
            operation: $operation,
            requestDTO: $requestDTO,
        ))->getBody()->getContents();

        return $this->mapper->map($json, DocumentRegistrationResponseDTO::class);
    }

    private function documentCorrection(Operation $operation, DocumentCorrectionRequestDTO $requestDTO): DocumentCorrectionResponseDTO
    {
        $json = $this->send(new DocumentCorrectionRequest(
            groupCode: $this->credentials->groupCode,
            operation: $operation,
            requestDTO: $requestDTO,
        ))->getBody()->getContents();

        return $this->mapper->map($json, DocumentCorrectionResponseDTO::class);
    }

    public function documentInfo(DocumentInfoRequestDTO $requestDTO): DocumentInfoResponseDTO
    {
        $json = $this->send(new DocumentInfoRequest(
            groupCode: $this->credentials->groupCode,
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
