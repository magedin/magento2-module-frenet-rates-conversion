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

namespace MagedIn\FrenetRatesConversion\Model\Validator;

use Frenet\ObjectType\Entity\Shipping\Quote\Service;
use Frenet\Shipping\Service\RateRequestProvider;

class ServiceConversionValidator implements ServiceValidatorInterface
{
    /**
     * @var RateRequestProvider
     */
    private $rateRequestProvider;

    /**
     * @var array
     */
    private $validators;

    public function __construct(
        RateRequestProvider $rateRequestProvider,
        array $validators = []
    ) {
        $this->rateRequestProvider = $rateRequestProvider;
        $this->validators = $validators;
    }

    /**
     * @inheritDoc
     */
    public function validate(Service $service): bool
    {
        try {
            /** @var ServiceValidatorInterface $validator */
            foreach ($this->validators as $validator) {
                if (!$validator->validate($service)) {
                    return false;
                }
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
