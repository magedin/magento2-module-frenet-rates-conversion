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

use Magento\Directory\Model\Currency;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * @var CurrencyFactory
     */
    private $currencyFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        CurrencyFactory $currencyFactory,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->currencyFactory = $currencyFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->getValue('active');
    }

    /**
     * @return bool
     */
    public function useStoreBaseCurrency(): bool
    {
        /**
         * If there's no conversion rate registered in Magento and exception will be thrown.
         */
        // return (bool) $this->getValue('use_store_base_currency');
        return true;
    }

    /**
     * @return Currency
     */
    public function getDefinedBaseCurrency(): Currency
    {
        return $this->currencyFactory->create()->load($this->getValue('defined_base_currency'));
    }

    /**
     * @return Currency
     */
    public function getBaseCurrency(): Currency
    {
        if ($this->useStoreBaseCurrency()) {
            return $this->getStore()->getBaseCurrency();
        }
        return $this->getDefinedBaseCurrency();
    }

    /**
     * @return string[]
     */
    public function getAllowedServiceCodes(): array
    {
        $allowed = $this->getValue('allowed_service_codes');
        return explode(',', $allowed);
    }

    /**
     * @return array
     */
    public function getNotConvertibleCountries(): array
    {
        $countries = $this->getValue('not_convertible_countries');
        return explode(',', $countries);
    }

    /**
     * @return StoreInterface|null
     */
    private function getStore(): StoreInterface
    {
        try {
            return $this->storeManager->getStore();
        } catch (\Exception $e) {
            return $this->storeManager->getDefaultStoreView();
        }
    }

    /**
     * @param string $field
     *
     * @return mixed
     */
    private function getValue(string $field)
    {
        return $this->scopeConfig->getValue(
            implode('/', ['carriers', 'frenetshipping', 'rates_conversion', $field])
        );
    }
}
