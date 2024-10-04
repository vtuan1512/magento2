<?php

declare(strict_types=1);

namespace Tigren\CustomerGroupCatalog\Service;

use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\Collection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\DB\Select;

class RulesProvider
{

    public function __construct(private CollectionFactory $collectionFactory)
    {}

    public function getPosts(): Collection
    {
        $collection = $this->getCollection();
        $collection->setOrder('created_at', Select::SQL_DESC);
        return $collection;
    }

    private function getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}
