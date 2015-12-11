<?php
namespace Celebros\AutoComplete\Helper;

use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const QUERY_PARAM_NAME = 'q';

    const XML_PATH_ENABLED                 = 'celebros_autocomplete/general/enabled';
    const XML_PATH_CUSTOMER_NAME           = 'celebros_autocomplete/general/customer_name';
    const XML_PATH_FRONTEND_SERVER_ADDRESS = 'celebros_autocomplete/general/frontend_address';
    const XML_PATH_SCRIPT_SERVER_ADDRESS   = 'celebros_autocomplete/general/scriptserver_address';

    public function getExternalJsUrls()
    {
        $protocol = $this->_getRequest()->isSecure() ? 'https' : 'http';
        $autocompleteJsUrl = $protocol . '://'
            . implode('/', [$this->getScriptServerAddress(), 'AutoComplete/Scripts/CelebrosAutoCompleteV2.js']);
        return [$autocompleteJsUrl];
    }

    public function getExternalCssUrls()
    {
        return [];
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
}