<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
*/

namespace MagePal\CheckoutSuccessMiscScript\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE = 'magepal_checkout/misc_script/active';

    protected $variables =[
        'order_id' => null,
        'total' => null,
        'sub_total' => null,
        'shipping' => null,
        'tax' => null,
        'coupon_code' => null,
        'discount' => null,
    ];

    const TEMPLATE_START = '{{';
    const TEMPLATE_END = '}}';

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        parent::__construct($context);
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * Whether is active
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Customer dashboard active
     *
     * @return bool
     */
    public function getScripts()
    {
        $json = $this->scopeConfig->getValue('magepal_checkout/misc_script/scripts', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $this->jsonHelper->jsonDecode($json);
    }

    /**
     * Format Price
     *
     * @param $price
     * @return float
     */
    public function formatPrice($price)
    {
        return (float)sprintf('%.2F', $price);
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariableData($key, $value)
    {
        if (array_key_exists($key, $this->variables)) {
            $this->variables[$key] = $value;
        }

        return $this;
    }

    public function getTemplateVariableKey()
    {
        $keys = [];

        foreach ($this->getVariables() as $key => $val) {
            $keys[] = self::TEMPLATE_START . $key . self::TEMPLATE_END;
        }

        return $keys;
    }

    public function getTemplateVariable()
    {
        $values = [];

        foreach ($this->getVariables() as $key => $val) {
            $values[self::TEMPLATE_START . $key . self::TEMPLATE_END] = $val;
        }

        return $values;
    }
}
