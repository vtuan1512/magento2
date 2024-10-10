<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Blog\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\Blog\Model\ResourceModel\Post\CollectionFactory;

/**
 *
 */
class PaginatedBlogDetails implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Field $field
     * @param Context $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        $pageSize = isset($args['pageSize']) ? (int)$args['pageSize'] : 5;
        $currentPage = isset($args['currentPage']) ? (int)$args['currentPage'] : 1;

        $collection = $this->collectionFactory->create();
        $totalCount = $collection->getSize();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($currentPage);

        $items = [];
        foreach ($collection as $item) {
            $items[] = [
                'post_id' => $item->getPostId(),
                'title' => $item->getTitle(),
                'post_image' => $item->getPostImage(),
                'full_content' => $item->getFullContent(),
                'short_content' => $item->getShortContent(),
                'author' => $item->getAuthor(),
                'status' => $item->getStatus(),
                'cate_id' => $item->getCateId(),
            ];
        }

        return [
            'items' => $items,
            'page_info' => [
                'current_page' => $currentPage,
                'total_pages' => (int)ceil($totalCount / $pageSize),
            ],
        ];
    }
}
