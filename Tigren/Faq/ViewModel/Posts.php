<?php

declare(strict_types=1);

namespace Tigren\Faq\ViewModel;

use Tigren\Faq\Model\ResourceModel\Post\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Tigren\Faq\Service\PostsProvider;


class Posts implements ArgumentInterface
{
    public function __construct(
        private PostsProvider $postsProvider,

    ) {}

    public function getPosts($productId): Collection
    {
        return $this->postsProvider->getPosts($productId);

    }


}
