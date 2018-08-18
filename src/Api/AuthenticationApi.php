<?php
declare(strict_types=1);

namespace R6API\Client\Api;

use R6API\Client\Http\HttpClientInterface;
use R6API\Client\Routing\UriGeneratorInterface;
use R6API\Client\Security\Authentication;

/**
 * API implementation to manage the authentication.
 *
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
class AuthenticationApi implements AuthenticationApiInterface
{
    /** @var string */
    const UBI_APPID = '39baebad-39e5-4552-8c25-2c9b919064e2';

    /** @var string */
    const TICKET_URI = 'ubiservices/v2/profiles/sessions';

    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var UriGeneratorInterface */
    protected $uriGenerator;

    /**
     * @param HttpClientInterface   $httpClient
     * @param UriGeneratorInterface $uriGenerator
     */
    public function __construct(HttpClientInterface $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(Authentication $authentication): array
    {
        $headers = [
            'Content-Type'  => 'application/json; charset=UTF-8',
            'Authorization' => $authentication->getBearer(),
            'Ubi-AppId'     => static::UBI_APPID
        ];

        $uri = $this->uriGenerator->generate(static::TICKET_URI);
        $response = $this->httpClient->sendRequest('POST', $uri, $headers);

        return json_decode($response->getBody()->getContents(), true);
    }
}