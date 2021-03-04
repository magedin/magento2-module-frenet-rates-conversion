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

use Frenet\Shipping\Model\CacheManager;
use Frenet\Shipping\Model\Calculator as FrenetCalculator;
use Frenet\Shipping\Model\Packages\PackagesCalculator;
use Frenet\Shipping\Service\RateRequestProvider;

class Calculator extends FrenetCalculator
{
    /**
     * @var ShippingQuoteProcessor
     */
    private $quoteProcessor;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        CacheManager $cacheManager,
        PackagesCalculator $packagesCalculator,
        RateRequestProvider $rateRequestProvider,
        ShippingQuoteProcessor $quoteProcessor,
        Config $config
    ) {
        parent::__construct($cacheManager, $packagesCalculator, $rateRequestProvider);
        $this->quoteProcessor = $quoteProcessor;
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function getQuote(): array
    {
        $quotes = parent::getQuote();
        if (!$this->config->isActive()) {
            return $quotes;
        }
        return $this->quoteProcessor->process($quotes);
    }
}
