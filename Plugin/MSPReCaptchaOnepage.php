<?php
/**
 * Copyright © O2TI. All rights reserved.
 *
 * @author    Bruno Elisei <brunoelisei@o2ti.com>
 * See COPYING.txt for license details.
 */

namespace O2TI\CheckoutIdentificationStep\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use MSP\ReCaptcha\Block\LayoutProcessor\Checkout\Onepage;
use MSP\ReCaptcha\Model\Config as MSPConfig;
use MSP\ReCaptcha\Model\LayoutSettings;
use O2TI\CheckoutIdentificationStep\Helper\Config;

/**
 *  MSPReCaptchaOnepage - MSP Insert ReCaptcha to Step Identification.
 */
class MSPReCaptchaOnepage
{
    /**
     * @var LayoutSettings
     */
    protected $layoutSettings;

    /**
     * @var MSPConfig
     */
    protected $mspConfig;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param LayoutSettings       $layoutSettings
     * @param MSPConfig            $mspConfig
     * @param Config               $config
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        LayoutSettings $layoutSettings,
        MSPConfig $mspConfig,
        Config $config
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->layoutSettings = $layoutSettings;
        $this->mspConfig = $mspConfig;
        $this->config = $config;
    }

    /**
     * Implements MSP ReCaptcha.
     *
     * @param Onepage  $layoutProcessor
     * @param callable $proceed
     * @param array    $args
     *
     * @return array
     */
    public function aroundProcess(Onepage $layoutProcessor, callable $proceed, ...$args): array
    {
        $jsLayout = $proceed(...$args);
        if ($this->config->isEnabled()) {
            if ($this->mspConfig->isEnabledFrontend()) {
                $settings = $this->layoutSettings->getCaptchaSettings();
                // phpcs:ignore
                $jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['msp_recaptcha']['settings'] = $settings;
                // phpcs:ignore
                $jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['createAccount']['children']['msp_recaptcha']['settings'] = $settings;
            } else {
                // phpcs:ignore
                if (isset($jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['msp_recaptcha'])
                ) {
                    // phpcs:ignore
                    unset($jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['msp_recaptcha']);
                }
                // phpcs:ignore
                if (isset($jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['createAccount']['children']['msp_recaptcha'])
                ) {
                    // phpcs:ignore
                    unset($jsLayout['components']['checkout']['children']['steps']['children']['identification-step']['children']['identification']['children']['createAccount']['children']['msp_recaptcha']);
                }
            }
            $layoutProcessor = $layoutProcessor;
        }

        return $jsLayout;
    }
}
