<?php

declare(strict_types=1);

namespace Tigren\Testimonial\Service;

use Tigren\Testimonial\Model\ResourceModel\Post;

class PostIdChecker
{
    public function __construct(private Post $post)
    {
    }

    public function checkUrlKey( $post_id): int
    {
        $connection = $this->post->getConnection();
        $select = $connection->select()
            ->from($connection->getTableName('tigren_testimonial'), 'entity_id')
            ->where('entity_id = ?', $post_id);

        return (int) $connection->fetchOne($select);
    }
}
