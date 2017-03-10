<?php
/**
 * Observer
 * 
 * @category    Sysint
 * @package     Sysint_OrderLog
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author SYSINT Team <one@sysint.net>
 */
class Sysint_OrderLog_Model_Observer {
    
    /**
     * Log order, add record to table transactions
     * 
     * @param Varien_Event_Observer $observer
     * @return Sysint_OrderLog_Model_Observer
     */
    public function logOrder($observer) {
        
        /* @var $order Mage_Sales_Model_Order */
        $order = $observer->getEvent()->getOrder();
        
        //Can log
        if ($this->canLog($order)
                && !$this->resourceTransaction()->checkTransaction($order->getEntityId())){
            
            //Add transaction
            $this->resourceTransaction()
                    ->addTransaction($order->getEntityId(), 
                            $order->getGrandTotal(), 
                            $this->helper()->getLogDecimalFactor()
                            );
            
            if ($this->helper()->canAddComment()){
                $order->addStatusHistoryComment($this->helper()->__("Added value %s", $this->resourceTransaction()->getLastAddedValue()))
                    ->save();
            }
        }
        
        return $this;
    }
    
    /**
     * Resource transaction
     * @return Sysint_OrderLog_Model_Resource_Transaction
     */
    protected function resourceTransaction() {
        return Mage::getResourceSingleton('orderlog/transaction');
    }
    
    /**
     * Can logging for order
     * @param Mage_Sales_Model_Order $order
     * @return bool
     */
    protected function canLog($order) {
        if ($order instanceof Mage_Sales_Model_Order
                && $this->helper()->isLogEnable()){
            return $order->getStatus() == $this->helper()->getOrderStatus();
        }
        return false;
    }
    
    /**
     * Helper
     * @return Sysint_OrderLog_Helper_Data
     */
    protected function helper() {
        return Mage::helper('orderlog');
    }
    
}
