<?php

declare(strict_types=1);

namespace Tigren\Blog\Service;

use Tigren\Blog\Model\ResourceModel\Post;

class PostIdChecker
{
    public function __construct(private Post $post)
    {
    }

    public function checkUrlKey( $post_id): int
    {
        $connection = $this->post->getConnection();
        $select = $connection->select()
            ->from($connection->getTableName('custom_blog_post'), 'post_id')
            ->where('post_id = ?', $post_id);

        return (int) $connection->fetchOne($select);
    }
}
