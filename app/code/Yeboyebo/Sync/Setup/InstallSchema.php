<?php

namespace Yeboyebo\Sync\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

	    $setup->getConnection()->addColumn(
		    $setup->getTable('sales_order'),
		    'synchronized',
		    ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
		     'nullable' => false,
		     'default' => '0',
		     'comment' => 'Sincronizado con ERP']);

        $setup->endSetup();
    }
}
