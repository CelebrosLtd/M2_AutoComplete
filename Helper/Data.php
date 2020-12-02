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
    const XML_PATH_USE_CUSTOMER_GROUP      = 'celebros_autocomplete/general/use_customer_group';
    const XML_PATH_ALLOWED_CUSTOMER_GROUPS = 'celebros_autocomplete/general/allowed_customer_groups';
    const XML_PATH_CUSTOMER_NAME_TEMPLATE  = 'celebros_autocomplete/general/customer_name_template';
    
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    
    /**
     * @var \Celebros\AutoComplete\Model\Config\Source\Versions
     */
    protected $_versions;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Group $groupCollection
     * @param \Celebros\AutoComplete\Model\Config\Source\Versions $versions
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Group $groupCollection,
        \Celebros\AutoComplete\Model\Config\Source\Versions $versions
    ) {
        $this->_customerSession = $customerSession;
        $this->_groupCollection = $groupCollection;
        $this->_versions = $versions;
        parent::__construct($context);
    }
    
    /**
     * Get current protocol
     * @return string
     */
    public function getProtocol() : string
    {
        return $this->_getRequest()->isSecure() ? 'https' : 'http';
    }
    
    /**
     * Get current search query request
     * @return string
     */
    public function getQueryParamName() : string
    {
        return self::QUERY_PARAM_NAME;
    }
    
    /**
     * Check if module enabled
     * @return bool
     */
    public function isEnabled($store = null) : bool
    {
        return (bool) $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function useCustomerGroup($store = null)
    {
        return (bool) $this->scopeConfig->isSetFlag(
            self::XML_PATH_USE_CUSTOMER_GROUP,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function getCustomerName($store = null) : string
    {
        $custName = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_NAME,
            ScopeInterface::SCOPE_STORE,
            $store
        );
            
        if ($this->useCustomerGroup($store)
        && $this->_customerSession->isLoggedIn()) {
            $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
            if (in_array($customerGroupId, $this->getAllowedCustomerGroups($store))) {
                $group = $this->_groupCollection->load($customerGroupId);
                $customerGroupCode = $group->getCustomerGroupCode();
                $data = [
                    'customer_name' => $custName,
                    'customer_group_id' => $customerGroupId,
                    'customer_group_code' => $customerGroupCode
                ];
                
                $custName = $this->renderCustomerName(
                    $this->getCustomerNameTemplate($store),
                    $data
                );
            }
        }
        
        return $custName;
    }
    
    public function renderCustomerName(string $custName, array $data) : string
    {
        foreach ($data as $key => $value) {
            if (strpos($custName, "{{" . $key . "}}") !== false) {
                $custName = str_replace("{{" . $key . "}}", $value, $custName);
            }
        }
        
        return $this->sanitizeCustomerName($custName);
    }
    
    public function sanitizeCustomerName(string $custName) : string
    {
        return str_replace(" ", "_", $custName);
    }
    
    public function getAllowedCustomerGroups($store = null) : array
    {
        return explode(',', $this->scopeConfig->getValue(
            self::XML_PATH_ALLOWED_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE,
            $store
        ));
    }
    
    public function getCustomerNameTemplate($store = null) : string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_NAME_TEMPLATE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function getFrontendServerAddress($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_FRONTEND_SERVER_ADDRESS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function getScriptServerAddress($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SCRIPT_SERVER_ADDRESS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    
    public function getAcVersion($store = null)
    {
        $version = $this->scopeConfig->getValue(
            self::XML_PATH_AC_VERSION,
            ScopeInterface::SCOPE_STORE,
            $store
        );
        
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
