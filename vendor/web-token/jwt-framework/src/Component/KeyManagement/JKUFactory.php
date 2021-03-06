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
use Jose\Component\Core\JWKSet;

/**
 * Class JKUFactory.
 */
final class JKUFactory extends UrlKeySetFactory
{
    private $jsonConverter;

    /**
     * JKUFactory constructor.
     *
     * @param JsonConverter  $jsonConverter
     * @param HttpClient     $client
     * @param RequestFactory $requestFactory
     */
    public function __construct(JsonConverter $jsonConverter, HttpClient $client, RequestFactory $requestFactory)
    {
        parent::__construct($client, $requestFactory);
        $this->jsonConverter = $jsonConverter;
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

        return JWKSet::createFromKeyData($data);
    }
}
