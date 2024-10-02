<?php

declare(strict_types=1);

namespace Tigren\CustomerGroupCatalog\Service;

use Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory\Collection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory\CollectionFactory;
use Magento\Framework\DB\Select;

class PostsProvider
{

    public function __construct(private CollectionFactory $collectionFactory)
    {}

    public function getPosts(): Collection
    {
        $collection = $this->getCollection();
//        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->setOrder('created_at', Select::SQL_DESC);
        return $collection;
    }

    private function getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}
