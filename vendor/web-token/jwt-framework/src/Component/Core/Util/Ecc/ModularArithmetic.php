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

namespace Jose\Component\Core\Util\Ecc;

/**
 * Class ModularArithmetic.
 */
final class ModularArithmetic
{
    /**
     * @param \GMP $minuend
     * @param \GMP $subtrahend
     * @param \GMP $modulus
     *
     * @return \GMP
     */
    public static function sub(\GMP $minuend, \GMP $subtrahend, \GMP $modulus): \GMP
    {
        return Math::mod(Math::sub($minuend, $subtrahend), $modulus);
    }

    /**
     * @param \GMP $multiplier
     * @param \GMP $muliplicand
     * @param \GMP $modulus
     *
     * @return \GMP
     */
    public static function mul(\GMP $multiplier, \GMP $muliplicand, \GMP $modulus): \GMP
    {
        return Math::mod(Math::mul($multiplier, $muliplicand), $modulus);
    }

    /**
     * @param \GMP $dividend
     * @param \GMP $divisor
     * @param \GMP $modulus
     *
     * @return \GMP
     */
    public static function div(\GMP $dividend, \GMP $divisor, \GMP $modulus): \GMP
    {
        return self::mul($dividend, Math::inverseMod($divisor, $modulus), $modulus);
    }
}
