<?php
/**
 * @method string getComment()
 * @method Sysint_CustomerImage_Model_Album setComment(string $text)
 */
class Sysint_CustomerImage_Model_Album extends Mage_Core_Model_Abstract {
    
    const DEFAULT_ALBUM = 1;
    
    protected function _construct() {
        $this->_init('customerimage/album');
    }    
}
