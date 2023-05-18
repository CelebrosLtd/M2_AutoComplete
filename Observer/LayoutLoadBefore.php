<?php

/**
 * Celebros (C) 2023. All Rights Reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 */

namespace Celebros\AutoComplete\Observer;

use Magento\Framework\Event\ObserverInterface;

class LayoutLoadBefore implements ObserverInterface
{
    public const VERSION_HADLE_PREFIX = 'celebros_ac_v';

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

    /**
     * @var \Celebros\AutoComplete\Helper\Data
     */
    protected $helper;

    /**
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Celebros\AutoComplete\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout,
        \Celebros\AutoComplete\Helper\Data $helper
    ) {
        $this->layout = $layout;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isEnabled() && !$this->helper->getExternalCssUrl()) {
            $version = $this->helper->getAcVersion();
            $this->layout->getUpdate()->addHandle(self::VERSION_HADLE_PREFIX . $version);
        }

        return $this;
    }
}
