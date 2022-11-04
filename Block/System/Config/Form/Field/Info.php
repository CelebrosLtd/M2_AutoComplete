<?php

/**
 * Celebros (C) 2022. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */

namespace Celebros\AutoComplete\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Module\ResourceInterface;

class Info extends \Magento\Config\Block\System\Config\Form\Field
{
    public const MODULE_NAME = 'Celebros_AutoComplete';

    /**
     * @var ResourceInterface
     */
    protected $_moduleDb;

    /**
     * @param ResourceInterface $moduleDb
     * @return void
     */
    public function __construct(
        ResourceInterface $moduleDb
    ) {
        $this->_moduleDb = $moduleDb;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $id = $element->getHtmlId();
        $html = '<tr id="row_' . $id . '">';
        $html .= '<td class="label">' . __('Module Version') . '</td><td class="value">'
            . $this->getModuleVersion() . '</td><td class="scope-label"></td>';
        $html .= '</tr>';

        return $html;
    }

    /**
     * @return string
     */
    public function getModuleVersion()
    {
        return $this->_moduleDb->getDbVersion(self::MODULE_NAME);
    }
}
