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
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\Blog\Model\PostFactory;

class AllBlogDetails implements ResolverInterface
{
    private $postFactory;

    public function __construct(
        PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
    }

    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $posts = $this->postFactory->create()->getCollection();
        $result = [];

        foreach ($posts as $post) {
            $result[] = $post->getData();
        }

        return $result;
    }
}
