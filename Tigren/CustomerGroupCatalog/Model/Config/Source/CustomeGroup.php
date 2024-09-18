<?php

namespace Tigren\CustomerGroupCatalog\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class CustomeGroup implements OptionSourceInterface
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function toOptionArray()
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('customer_group');
        $select = $connection->select()->from($table, ['customer_group_code','customer_group_id']);
        $categories = $connection->fetchAll($select);

        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'value' => $category['customer_group_id'],
                'label' => $category['customer_group_code']
            ];
        }

        return $options;
    }
}
