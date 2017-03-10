<?php
/**
 * Helper functions
 * 
 * @category    Sysint
 * @package     Sysint_OrderLog
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author SYSINT Team <one@sysint.net>
 */
class Sysint_OrderLog_Helper_Data extends Mage_Core_Helper_Abstract{
    
    const XML_PATH_ENABLE         = 'sales/orderlog/enable';
    const XML_PATH_DECIMAL_FACTOR = 'sales/orderlog/decimal_factor';
    const XML_PATH_ORDER_STATUS   = 'sales/orderlog/order_status';
    const XML_PATH_ADD_COMMENT    = 'sales/orderlog/add_comment';
    
    /**
     * Retrieve flag - enable tranasction log
     * @return bool
     */
    public function isLogEnable() {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLE);
    }
    
    /**
     * Add comments to order after transaction
     * @return bool
     */
    public function canAddComment() {
        return Mage::getStoreConfigFlag(self::XML_PATH_ADD_COMMENT);
    }
    
    /**
     * Retrieve decimal factor value
     * @return float
     */
    public function getLogDecimalFactor() {
        return number_format(Mage::getStoreConfig(self::XML_PATH_DECIMAL_FACTOR), 2, '.', '');
    }
    
    /**
     * Order status
     * @return string
     */
    public function getOrderStatus() {
        return Mage::getStoreConfig(self::XML_PATH_ORDER_STATUS);
    }
}
