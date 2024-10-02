<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.1.0', '<')) {
            if (!$installer->tableExists('tigren_shipping_restrictions')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('tigren_shipping_restrictions')
                )->addColumn(
                    'rule_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Rule Id'
                )->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Name'
                )->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Description'
                )->addColumn(
                    'from_date',
                    Table::TYPE_DATE,
                    null,
                    ['nullable' => true, 'default' => null],
                    'From'
                )->addColumn(
                    'to_date',
                    Table::TYPE_DATE,
                    null,
                    ['nullable' => true, 'default' => null],
                    'To'
                )->addColumn(
                    'is_active',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Is Active'
                )->addColumn(
                    'conditions_serialized',
                    Table::TYPE_TEXT,
                    '2M',
                    [],
                    'Conditions Serialized'
                )->addColumn(
                    'sort_order',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Sort Order (Priority)'
                )->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Status'
                )->addColumn(
                    'store',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Store'
                )->addColumn(
                    'shipping_methods',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Shipping Methods'
                )->addColumn(
                    'customer_group',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Customer Group'
                )->addColumn(
                    'discard_subsequent_rules',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Discard Subsequent Rules'
                )->addIndex(
                    $installer->getIdxName('tigren_shipping_restrictions', ['sort_order', 'is_active', 'to_date', 'from_date']),
                    ['sort_order', 'is_active', 'to_date', 'from_date']
                )->setComment(
                    'Own Rules'
                );
                $installer->getConnection()->createTable($table);
            }
        }
        $installer->endSetup();
    }
}
