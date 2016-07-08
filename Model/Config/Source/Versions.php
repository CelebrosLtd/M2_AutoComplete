<?php
/**
 * Celebros
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 *
 ******************************************************************************
 * @category    Celebros
 * @package     Celebros_AutoComplete
 */
namespace Celebros\AutoComplete\Model\Config\Source;

class Versions implements \Magento\Framework\Option\ArrayInterface
{
    public $versions = [
        '2' => [
            'label' => 'V2'
        ], 
        '3' => [
            'label' => 'V3'
        ]
    ];
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->versions as $value => $version) {
            $result[] = [
                'value' => $value,
                'label' => $version['label']
            ];
        }
        return $result;
    }

}