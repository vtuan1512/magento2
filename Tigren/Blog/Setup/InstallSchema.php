<?php
namespace Tigren\Blog\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        /** custom_blog_post is the table name **/
        $installer = $setup;
        $installer->startSetup();

        // Tạo bảng custom_blog_post
        if (!$installer->tableExists('custom_blog_post')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('custom_blog_post')
            )
                ->addColumn(
                    'post_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Post ID'
                )
                ->addColumn(
                    'cate_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [],
                    'cate_id'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Title'
                )
                ->addColumn(
                    'post_image',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Post Image'
                )
                ->addColumn(
                    'list_image',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'List Image'
                )
                ->addColumn(
                    'full_content',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Full Content'
                )
                ->addColumn(
                    'short_content',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Short Content'
                )
                ->addColumn(
                    'author',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Author'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [],
                    'Status'
                )
                ->addColumn(
                    'published_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Published At'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setComment('Blog Post Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('custom_blog_post'),
                $setup->getIdxName(
                    $installer->getTable('custom_blog_post'),
                    ['title', 'post_image', 'list_image', 'full_content', 'short_content', 'author'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'post_image', 'list_image', 'full_content', 'short_content', 'author'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        // Tạo bảng blog_cate
        if (!$installer->tableExists('blog_category')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('blog_category')
            )
                ->addColumn(
                    'cate_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Category ID'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Category Name'
                )
                ->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Category Description'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '1'],
                    'Status'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setComment('Blog Category Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
?>
