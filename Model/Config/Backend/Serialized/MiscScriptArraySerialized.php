<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\CheckoutSuccessMiscScript\Model\Config\Backend\Serialized;

use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;

class MiscScriptArraySerialized extends ArraySerialized
{

    /**
     * @inheritDoc
     */
    public function afterLoad()
    {
        parent::afterLoad();
        $values = $this->getValue();
        if(is_array($values)){
            foreach ($values as &$value) {
                if (!array_key_exists('is_enabled', $value)) {
                    $value['is_enabled'] = '';
                }
            }
        }

        $this->setValue($values);
        return $this;
    }

    /**
     * @return $this
     */
    public function beforeSave()
    {
        $values = $this->getValue();

        if (is_array($values)) {
            foreach ($values as &$value) {
                if (is_array($value)) {
                    if (!array_key_exists('is_enabled', $value)) {
                        $value['is_enabled'] = '';
                    } else {
                        $value['is_enabled'] = 'checked';
                    }
                }
            }

            $this->setValue($values);
        }

        parent::beforeSave();
        return $this;
    }
}
