<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\CheckoutSuccessMiscScript\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
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
     * @var JsonHelper
     */
    protected $jsonHelper;

    /**
     * @param Context $context
     * @param JsonHelper $jsonHelper
     */
    public function __construct(
        Context $context,
        JsonHelper $jsonHelper
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
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Customer dashboard active
     *
     * @return bool
     */
    public function getScripts()
    {
        $json = $this->scopeConfig->getValue(
            'magepal_checkout/misc_script/scripts',
            ScopeInterface::SCOPE_STORE
        );

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

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setVariableData($key, $value)
    {
        if (array_key_exists($key, $this->variables)) {
            $this->variables[$key] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplateVariableKey()
    {
        $keys = [];

        foreach ($this->getVariables() as $key => $val) {
            $keys[] = self::TEMPLATE_START . $key . self::TEMPLATE_END;
        }

        return $keys;
    }

    /**
     * @return array
     */
    public function getTemplateVariable()
    {
        $values = [];

        foreach ($this->getVariables() as $key => $val) {
            $values[self::TEMPLATE_START . $key . self::TEMPLATE_END] = $val;
        }

        return $values;
    }
}
