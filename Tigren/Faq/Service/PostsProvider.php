<?php

declare(strict_types=1);

namespace Tigren\Faq\Service;

use Tigren\Faq\Model\ResourceModel\Post\Collection;
use Tigren\Faq\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\DB\Select;

class PostsProvider
{

    public function __construct(private CollectionFactory $collectionFactory)
    {}

    public function getPosts($productId): Collection
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('product', $productId);
        $collection->setOrder('creation_time', Select::SQL_DESC);

        return $collection;
    }

    private function getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}
