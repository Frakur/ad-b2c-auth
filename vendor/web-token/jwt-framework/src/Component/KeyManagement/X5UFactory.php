<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\KeyManagement;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Jose\Component\Core\Converter\JsonConverter;
use Jose\Component\Core\JWK;
use Jose\Component\Core\JWKSet;
use Jose\Component\KeyManagement\KeyConverter\KeyConverter;

/**
 * Class X5UFactory.
 */
final class X5UFactory extends UrlKeySetFactory
{
    private $jsonConverter;

    /**
     * X5UFactory constructor.
     *
     * @param JsonConverter  $jsonConverter
     * @param HttpClient     $client
     * @param RequestFactory $requestFactory
     */
    public function __construct(JsonConverter $jsonConverter, HttpClient $client, RequestFactory $requestFactory)
    {
        $this->jsonConverter = $jsonConverter;
        parent::__construct($client, $requestFactory);
    }

    /**
     * @param string $url
     * @param array  $header
     *
     * @throws \InvalidArgumentException
     *
     * @return JWKSet
     */
    public function loadFromUrl(string $url, array $header = []): JWKSet
    {
        $content = $this->getContent($url, $header);
        $data = $this->jsonConverter->decode($content);
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid content.');
        }

        $keys = [];
        foreach ($data as $kid => $cert) {
            if (false === strpos($cert, '-----BEGIN CERTIFICATE-----')) {
                $cert = '-----BEGIN CERTIFICATE-----'.PHP_EOL.$cert.PHP_EOL.'-----END CERTIFICATE-----';
            }
            $jwk = KeyConverter::loadKeyFromCertificate($cert);
            if (is_string($kid)) {
                $jwk['kid'] = $kid;
                $keys[$kid] = JWK::create($jwk);
            } else {
                $keys[] = JWK::create($jwk);
            }
        }

        return JWKSet::createFromKeys($keys);
    }
}
