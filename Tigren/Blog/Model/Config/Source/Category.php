<?php

namespace Tigren\Blog\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class Category implements OptionSourceInterface
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function toOptionArray()
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('blog_category');
        $select = $connection->select()->from($table, ['cate_id', 'name']);
        $categories = $connection->fetchAll($select);

        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'value' => $category['cate_id'],
                'label' => $category['name']
            ];
        }

        return $options;
    }
}
