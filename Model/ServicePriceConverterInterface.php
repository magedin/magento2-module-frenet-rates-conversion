<?php
/**
 * MagedIn Technology
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  MagedIn
 * @copyright Copyright (c) 2021 MagedIn Technology.
 *
 * @author    MagedIn Support <support@magedin.com>
 */

namespace MagedIn\FrenetRatesConversion\Model;

interface ServicePriceConverterInterface
{
    /**
     * @param float $price
     *
     * @return float
     */
    public function convert(float $price): float;
}
