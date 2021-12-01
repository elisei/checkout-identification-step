<?php
/**
 * MageSpecialist.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magespecialist.it so we can send you a copy immediately.
 *
 * @category   MSP
 *
 * @copyright  Copyright (c) 2017 Skeeller srl (http://www.magespecialist.it)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace O2TI\CheckoutIdentificationStep\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use MSP\ReCaptcha\Model\Config;
use MSP\ReCaptcha\Model\LayoutSettings;

class ReCaptchaLayoutSettings
{
    // phpcs:ignore
    public const XML_PATH_ENABLED_CHECKOUT_CREATE_ACCOUNT = 'msp_securitysuite_recaptcha/frontend/enabled_checkout_create_account';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Config               $config
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Config $config
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->config = $config;
    }

    /**
     * Implements MSP ReCaptcha config for frontend.
     *
     * @param LayoutSettings $layoutProcessor
     * @param callable       $proceed
     * @param array          $args
     *
     * @return array
     */
    public function aroundGetCaptchaSettings(LayoutSettings $layoutProcessor, callable $proceed, ...$args): array
    {
        $configs = $proceed(...$args);
        $configs['enabled']['checkout_create_account'] = $this->isEnabledCheckoutAccountCreate();

        return $configs;
    }

    /**
     * Return true if enabled on checkout create account.
     *
     * @return bool
     */
    public function isEnabledCheckoutAccountCreate()
    {
        if (!$this->config->isEnabledFrontend()) {
            return false;
        }

        return (bool) $this->scopeConfig->getValue(
            static::XML_PATH_ENABLED_CHECKOUT_CREATE_ACCOUNT,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
