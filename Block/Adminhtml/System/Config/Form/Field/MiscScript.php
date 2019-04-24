<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
*/

namespace MagePal\CheckoutSuccessMiscScript\Block\Adminhtml\System\Config\Form\Field;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\View\Element\AbstractBlock;
use MagePal\CheckoutSuccessMiscScript\Helper\Data;


/**
 * Class MiscScript
 * @package MagePal\CheckoutSuccessMiscScript\Block\Adminhtml\System\Config\Form\Field
 */
class MiscScript extends AbstractFieldArray
{

    /**
     * @var string
     */
    protected $_template = 'MagePal_CheckoutSuccessMiscScript::system/config/form/field/array.phtml';

    /**
     * @var Data
     */
    protected $helper;

    /**
     * MiscScript constructor.
     * @param Context $context
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helper,
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

    /**
     * @return string
     */
    public function getTemplateButtonList()
    {
        $html = '';

        foreach ($this->helper->getTemplateVariableKey() as $key) {
            $html .= sprintf(
                '<%s style="%s" data-mage-init=\\\'%s\\\' type="button"> %s </button>',
                'button',
                'margin:3px;',
                '{"checkoutSuccessMiscScript":{"textareaId":"<%- _id %>_scripts"}}',
                $key
            );
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
        if (!empty($params['renderer']) && $params['renderer'] instanceof AbstractBlock) {
            $this->_columns[$name]['renderer'] = $params['renderer'];
        }
    }

    /**
     * @param string $columnName
     * @return mixed|string
     * @throws Exception
     */
    public function renderCellTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
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
