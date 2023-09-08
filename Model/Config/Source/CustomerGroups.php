<?php

/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */

namespace Celebros\AutoComplete\Model\Config\Source;

class CustomerGroups implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    protected $_customerGroup;

    /**
     * @param \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup
    ) {
        $this->_customerGroup = $customerGroup;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->_customerGroup as $group) {
            if ($group->getCustomerGroupId()) {
                $result[] = [
                    'value' => $group->getData('customer_group_id'),
                    'label' => $group->getData('customer_group_code')
                ];
            }
        }

        return $result;
    }
}
