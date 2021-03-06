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

namespace Jose\Component\Signature\Serializer;

use Jose\Component\Signature\JWS;

/**
 * Interface JWSSerializater.
 */
interface JWSSerializer
{
    /**
     * The name of the serialization.
     *
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function displayName(): string;

    /**
     * Converts a JWS into a string.
     *
     * @param JWS      $jws
     * @param int|null $signatureIndex
     *
     * @throws \Exception
     *
     * @return string
     */
    public function serialize(JWS $jws, ?int $signatureIndex = null): string;

    /**
     * Loads data and return a JWS object.
     *
     * @param string $input A string that represents a JWS
     *
     * @throws \Exception
     *
     * @return JWS
     */
    public function unserialize(string $input): JWS;
}
