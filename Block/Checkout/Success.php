<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
*/

namespace MagePal\CheckoutSuccessMiscScript\Block\Checkout;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use MagePal\CheckoutSuccessMiscScript\Helper\Data;

/**
 * Class Success
 * @package MagePal\CheckoutSuccessMiscScript\Block\Checkout
 */
class Success extends Template
{
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var arrau
     */
    protected $templateArray;

    /**
     * @param Context $context
     * @param Data $helper
     * @param Session $checkoutSession
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helper,
        Session $checkoutSession,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->helper->isEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * @return OrderInterface
     */
    protected function getOrder()
    {
        if (!$this->order) {
            $this->order = $this->orderRepository->get($this->checkoutSession->getLastOrderId());
        }

        return $this->order;
    }

    /**
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return array
     */
    protected function getTemplateArray()
    {
        $order = $this->getOrder();

        $this->helper->setVariableData('order_id', $order->getIncrementId());
        $this->helper->setVariableData('total', $this->helper->formatPrice($order->getBaseGrandTotal()));
        $this->helper->setVariableData('sub_total', $this->helper->formatPrice($order->getBaseSubtotal()));
        $this->helper->setVariableData('shipping', $this->helper->formatPrice($order->getBaseShippingAmount()));
        $this->helper->setVariableData('tax', $this->helper->formatPrice($order->getTaxAmount()));
        $this->helper->setVariableData('coupon_code', $order->getCouponCode() ?: '');
        $this->helper->setVariableData('discount', $this->helper->formatPrice($order->getDiscountAmount()));

        return $this->helper->getTemplateVariable();
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function processTemplate($string)
    {
        if (empty($this->templateArray)) {
            $template = $this->getTemplateArray();

            $this->templateArray = str_replace(array_keys($template), array_values($template), $string);
        }

        return $this->templateArray;
    }

    /**
     * @return mixed
     */
    public function getActiveScripts()
    {
        $html = '';

        $scripts = $this->helper->getScripts();

        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                if (array_key_exists('is_enabled', $script)
                    && $script['is_enabled'] == 'checked'
                    && array_key_exists('scripts', $script)
                ) {
                    $html .= $script['scripts'];
                }
            }
        }

        return $this->processTemplate($html);
    }
}
