<?php
/**
 * Resource
 * 
 * @category    Sysint
 * @package     Sysint_OrderLog
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author SYSINT Team <one@sysint.net>
 */
class Sysint_OrderLog_Model_Resource_Transaction extends Mage_Core_Model_Resource_Db_Abstract {
    
    /**
     * Last added value to order
     * @var float
     */
    protected $_lastAddedValue;

    /**
     * Retrieve last added value to order
     * @return float
     */
    public function getLastAddedValue() {
        return $this->_lastAddedValue;
    }

    protected function _construct (){
        $this->_init('orderlog/transaction', 'transaction_id');
    }
    
    /**
     * Check transaction for order
     * @param int $orderId Order entity id
     * @return bool
     */
    public function checkTransaction($orderId) {
        if (is_numeric($orderId)){
            
            $adapter = $this->_getReadAdapter();
            
            $select = $adapter
                    ->select()
                    ->from($this->getMainTable(), array('transaction_id'))
                    ->where('order_id = :order_id');
            
            $bind = array(':order_id' => (int)$orderId);
            
            
            return $adapter->fetchOne($select, $bind) == true;
        }
        
        return false;
    }
    
    /**
     * Add transaction
     * 
     * @param int $orderId Order entity id
     * @param float $total Order grand total
     * @param float $addValue Some additional fee
     * @return Sysint_OrderLog_Model_Resource_Transaction
     */
    public function addTransaction($orderId, $total, $addValue) {
        if (is_numeric($orderId) && is_numeric($total) && is_numeric($addValue)){
            
            $adapter = $this->_getWriteAdapter();
            
            $this->beginTransaction();
            
            try{
                $this->commit();
                
                $this->_lastAddedValue = $total * $addValue;
                
                $adapter->insert($this->getMainTable(), array(
                    'order_id'    => $orderId,
                    'grand_total' => $this->_lastAddedValue,
                ));
                
            } catch (Exception $ex) {
                $this->rollBack();
                throw $ex;
            }
            
        }
        return $this;
    }
}