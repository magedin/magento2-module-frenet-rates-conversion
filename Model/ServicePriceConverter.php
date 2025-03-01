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

use MagedIn\FrenetRatesConversion\Model\DataProvider\StoreProvider;
use Psr\Log\LoggerInterface;

class ServicePriceConverter implements ServicePriceConverterInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var StoreProvider
     */
    private $storeProvider;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Config $config,
        StoreProvider $storeProvider,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->storeProvider = $storeProvider;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function convert(float $price): float
    {
        try {
            $baseCurrency = $this->config->getBaseCurrency();
            $serviceCurrency = $this->config->getServiceBaseCurrency();
            $rate = $baseCurrency->getRate($serviceCurrency->getCurrencyCode()) ?? 1;

            return (float) $price / $rate;
        } catch (\Exception $e) {
            $this->logger->error($e);
            return $price;
        }
    }
}
