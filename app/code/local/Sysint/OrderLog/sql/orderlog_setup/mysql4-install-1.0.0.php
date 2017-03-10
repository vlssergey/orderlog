<?php
/**
 * Create table
 */
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

//Drop table if exist
$installer->run(""
        . "DROP TABLE IF EXISTS `{$this->getTable('orderlog/transaction')}`;"
        );

/**
 * New table Transaction
 */
$transaction = $installer->getConnection()->newTable($installer->getTable('orderlog/transaction'))
        ->addColumn('transaction_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true, 
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
            ), 'Transaction Id')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('nullable' => false), 'Order id')
        ->addIndex($installer->getIdxName('orderlog/transaction', array('order_id')),  array('order_id'))
        ->addForeignKey(
                $installer->getFkName(
                        'orderlog/transaction',
                        'order_id',
                        'sales/order',
                        'entity_id'
                        ),
                'order_id', $installer->getTable('sales/order'), 'entity_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addColumn('grand_total', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array('nullable' => true), 'Grand total')
        ->setComment('Order transactions log');

$installer->getConnection()->createTable($transaction);
        

$installer->endSetup();
