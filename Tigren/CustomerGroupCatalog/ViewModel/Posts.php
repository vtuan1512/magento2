<?php

declare(strict_types=1);

namespace Tigren\CustomerGroupCatalog\ViewModel;

use Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Tigren\CustomerGroupCatalog\Service\PostsProvider;


class Posts implements ArgumentInterface
{
    public function __construct(
        private PostsProvider $postsProvider,

    ) {}

    public function getPosts($customerId): Collection
    {
        return $this->postsProvider->getPosts($customerId);
    }


}
