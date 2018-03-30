<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
*/

namespace MagePal\CheckoutSuccessMiscScript\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Locations Backend system config array field renderer
 */
class MiscScript extends AbstractFieldArray
{

    /**
     * @var string
     */
    protected $_template = 'MagePal_CheckoutSuccessMiscScript::system/config/form/field/array.phtml';

    /**
     * @var \MagePal\CheckoutSuccessMiscScript\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MagePal\CheckoutSuccessMiscScript\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Initialise columns for 'Store Locations'
     * Label is name of field
     * Class is storefront validation action for field
     *
     * @return void
     */
    protected function _construct()
    {
        $this->addColumn(
            'is_enabled',
            [
                'label' => __('Is Enabled'),
                'class' => '',
                'type' => 'checkbox'
            ]
        );
        $this->addColumn(
            'title',
            [
                'label' => __('Title/Description'),
                'class' => 'validate-no-empty',
                'type' => 'text'
            ]
        );
        $this->addColumn(
            'scripts',
            [
                'label' => __('Scripts'),
                'class' => 'validate-no-empty greater-than-equals-to-0',
                'type' => 'textarea'
            ]
        );
        $this->_addAfter = false;
        parent::_construct();
    }

    public function getTemplateButtonList()
    {
        $html = '';

        foreach ($this->helper->getTemplateVariableKey() as $key) {
            $html .= '<button style="margin:3px;" data-mage-init=\\\'{"checkoutSuccessMiscScript":{"textareaId":"<%- _id %>_scripts"}}\\\' type="button">' . $key . '</button>';
        }

        return $html;
    }

    /**
     * Add a column to array-grid
     *
     * @param string $name
     * @param array $params
     * @return void
     */
    public function addColumn($name, $params)
    {
        $this->_columns[$name] = [
            'label' => $this->_getParam($params, 'label', 'Column'),
            'size' => $this->_getParam($params, 'size', false),
            'style' => $this->_getParam($params, 'style'),
            'class' => $this->_getParam($params, 'class'),
            'type' => $this->_getParam($params, 'type', 'text'),
            'renderer' => false,
        ];
        if (!empty($params['renderer']) && $params['renderer'] instanceof \Magento\Framework\View\Element\AbstractBlock) {
            $this->_columns[$name]['renderer'] = $params['renderer'];
        }
    }

    public function renderCellTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new \Exception('Wrong column name specified.');
        }
        $column = $this->_columns[$columnName];
        $inputName = $this->_getCellInputElementName($columnName);

        if ($column['renderer']) {
            return str_replace(["\n", "\t", "\r"], '', $column['renderer']->setInputName(
                $inputName
            )->setInputId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setColumnName(
                $columnName
            )->setColumn(
                $column
            )->toHtml());
        }

        if ($column['type'] == 'text') {
            return '<input type="' . $column['type'] . '" id="' . $this->_getCellInputElementId(
                    '<%- _id %>',
                    $columnName
                ) .
                '"' .
                ' name="' .
                $inputName .
                '" value="<%- ' .
                $columnName .
                ' %>" ' .
                ($column['size'] ? 'size="' .
                    $column['size'] .
                    '"' : '') .
                ' class="' .
                (isset(
                    $column['class']
                ) ? $column['class'] : 'input-text') . '"' . (isset(
                    $column['style']
                ) ? ' style="' . $column['style'] . '"' : '') . '/>';
        } elseif ($column['type'] == 'checkbox') {
            return '<input type="' . $column['type'] . '" id="' . $this->_getCellInputElementId(
                    '<%- _id %>',
                    $columnName
                ) .
                '"' .
                ' name="' .
                $inputName .
                '" checked="<%- ' .
                $columnName .
                ' %>" ' .
                ($column['size'] ? 'size="' .
                    $column['size'] .
                    '"' : '') .
                ' class="' .
                (isset(
                    $column['class']
                ) ? $column['class'] : 'input-text') . '"' . (isset(
                    $column['style']
                ) ? ' style="' . $column['style'] . '"' : '') . '/>';
        } else {
            return '<textarea  id="' . $this->_getCellInputElementId(
                    '<%- _id %>',
                    $columnName
                ) .
                '"' .
                ' name="' .
                $inputName .
                '" ' .
                ($column['size'] ? 'size="' .
                    $column['size'] .
                    '"' : '') .
                ' class="' .
                (isset(
                    $column['class']
                ) ? $column['class'] : 'input-text') . '"' . (isset(
                    $column['style']
                ) ? ' style="' . $column['style'] . '"' : '') . '><%- ' . $columnName . ' %></textarea>';
        }
    }
}
