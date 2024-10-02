<?php

namespace Tigren\Faq\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class Product implements OptionSourceInterface
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function toOptionArray()
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('catalog_product_entity');
        $select = $connection->select()->from($table, ['entity_id','sku']);
        $categories = $connection->fetchAll($select);

        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'value' => $category['entity_id'],
                'label' => $category['sku']
            ];
        }

        return $options;
    }
}
