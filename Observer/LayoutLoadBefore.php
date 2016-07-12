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
namespace Celebros\AutoComplete\Observer;

use Magento\Framework\Event\ObserverInterface;

class LayoutLoadBefore implements ObserverInterface
{
    const VERSION_HADLE_PREFIX = 'celebros_ac_v';
    
    /**
     * Https request
     *
     * @var \Zend\Http\Request
     */
    protected $_request;
    protected $_helper;
    protected $_layout;
    
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Celebros\AutoComplete\Helper\Data $celHelper
    ) {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_helper = $celHelper;
    }
    
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_helper->isEnabled()) {
            $version = $this->_helper->getAcVersion();
            $this->_layout->getUpdate()->addHandle(self::VERSION_HADLE_PREFIX . $version);
        }
        
        return $this;
    }
    
}