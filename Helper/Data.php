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
namespace Celebros\AutoComplete\Helper;

use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const QUERY_PARAM_NAME = 'q';
    const XML_PATH_ENABLED                 = 'celebros_autocomplete/general/enabled';
    const XML_PATH_CUSTOMER_NAME           = 'celebros_autocomplete/general/customer_name';
    const XML_PATH_FRONTEND_SERVER_ADDRESS = 'celebros_autocomplete/general/frontend_address';
    const XML_PATH_SCRIPT_SERVER_ADDRESS   = 'celebros_autocomplete/general/scriptserver_address';
    const XML_PATH_AC_VERSION              = 'celebros_autocomplete/general/acversion';
    const XML_PATH_EXT_CSS_ENABLED         = 'celebros_autocomplete/general/ext_css_enabled';
    const XML_PATH_EXT_CSS_URL             = 'celebros_autocomplete/general/ext_css_url';
    
    protected $_versions;
    protected $_acversiondata;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Celebros\AutoComplete\Model\Config\Source\Versions $versions
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Celebros\AutoComplete\Model\Config\Source\Versions $versions        
    ) {
        $this->_versions = $versions;
        parent::__construct($context);
    }
    
    public function getProtocol()
    {
        return $this->_getRequest()->isSecure() ? 'https' : 'http';
    }
    
    public function getQueryParamName()
    {
        return self::QUERY_PARAM_NAME;
    }
    
    public function isEnabled($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $store);
    }
    
    public function getCustomerName($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_NAME, ScopeInterface::SCOPE_STORE, $store);
    }
    
    public function getFrontendServerAddress($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_FRONTEND_SERVER_ADDRESS, ScopeInterface::SCOPE_STORE, $store);
    }
    
    public function getScriptServerAddress($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SCRIPT_SERVER_ADDRESS, ScopeInterface::SCOPE_STORE, $store);
    }
    
    public function getAcVersion($store = null)
    {
        $version = $this->scopeConfig->getValue(
            self::XML_PATH_AC_VERSION, ScopeInterface::SCOPE_STORE, $store);
        return (int)$version;
    }
    
    public function getVersionTemplate($store = null)
    {
        return "Celebros_AutoComplete::search/form.mini/v" . $this->getAcVersion($store) .".phtml";
    }
    
    public function isExternalCss($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EXT_CSS_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function getExternalCssUrl($store = null)
    {
        if ($this->isExternalCss($store)) {
            return $this->scopeConfig->getValue(
                self::XML_PATH_EXT_CSS_URL,
                ScopeInterface::SCOPE_STORE,
                $store
            );
        }
        
        return false;
    }
    
}