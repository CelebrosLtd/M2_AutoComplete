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

class Versions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    public $versions = [];

    /**
     * @param array $versions
     * @return void
     */
    public function __construct(
        array $versions = []
    ) {
        $this->versions = $versions;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->versions as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $result;
    }
}
