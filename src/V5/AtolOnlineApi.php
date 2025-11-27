<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5;

use DF\AtolOnline\Exceptions\AtolOnlineApiV5ErrorException;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenRequestDTO;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenResponseDTO;
use DF\AtolOnline\V5\Mappers\ErrorResponseMapper;
use DF\AtolOnline\V5\Mappers\GetTokenResponseMapper;
use DF\AtolOnline\V5\Requests\GetTokenRequest;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

readonly class AtolOnlineApi
{
    public function __construct(
        private ClientInterface $httpClient,
    ) {}

    public function getToken(GetTokenRequestDTO $requestDTO): GetTokenResponseDTO
    {
        return GetTokenResponseMapper::fromJsonResponse(
            response: $this->send(
                request: new GetTokenRequest($requestDTO),
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
