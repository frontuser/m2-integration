<?php
/**
 * Frontuser Integration
 * Copyright © 2017 Frontuser. All rights reserved.
 *
 * @category    Frontuser
 * @package     Frontuser_Integration
 * @author      Frontuser Team <support@frontuser.com>
 * @copyright   Frontuser (https://frontuser.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Frontuser\Integration\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
	/**
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
	    $eavTable = $setup->getTable('quote');
	    $connection = $setup->getConnection();

	    /**
	     * Drop futoken columns
	     */
	    $setup->getConnection()->dropColumn($eavTable,'futoken');

	    /**
	     * Add futoken columns
	     */
	    $connection->addColumn($eavTable, 'futoken', [
		    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		    'length' => 64,
		    'nullable' => false,
		    'comment' => 'Store random code to identify cart',
	    ]);

        $setup->endSetup();
    }
}
