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

declare(strict_types=1);

namespace MagedIn\FrenetRatesConversion\Model;

use Frenet\ObjectType\Entity\Shipping\Quote\Service;

class ShippingQuoteProcessor
{
    /**
     * @var ServiceProcessor
     */
    private $serviceProcessor;

    public function __construct(
        ServiceProcessor $serviceProcessor
    ) {
        $this->serviceProcessor = $serviceProcessor;
    }

    /**
     * @param Service[] $quotes
     *
     * @return array
     */
    public function process(array $quotes): array
    {
        if (empty($quotes)) {
            return $quotes;
        }

        $newQuotes = [];
        foreach ($quotes as $service) {
            if (!$service instanceof Service) {
                continue;
            }
            $newQuotes[] = $this->serviceProcessor->process($service);
        }
        return $newQuotes;
    }
}
