<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Blog\Api;

interface CustomInterface
{
    /**
     * Retrieve all posts.
     *
     * @return array
     */
    public function getAllPosts();

    /**
     * Retrieve a post by ID.
     *
     * @param int $id
     * @return array
     */
    public function getById($id);

    /**
     * Delete a post by ID.
     *
     * @param int $id
     * @return string
     */
    public function deleteById($id);

    /**
     * Thêm mới một bài viết
     *
     * @param string $title
     * @param int $cate_id
     * @param string $post_image
     * @param string $list_image
     * @param string $author
     * @param string $full_content
     * @param string $short_content
     * @param int $status
     * @return string
     */
    public function insert(
        $title,
        $cate_id,
        $post_image,
        $list_image,
        $author,
        $full_content,
        $short_content,
        $status
    );

    /**
     * Cập nhật một bài viết theo ID
     *
     * @param int $post_id
     * @param string $title
     * @param int $cate_id
     * @param string $post_image
     * @param string $list_image
     * @param string $author
     * @param string $full_content
     * @param string $short_content
     * @param int $status
     * @return string
     */
    public function updateById(
        $post_id,
        $title,
        $cate_id,
        $post_image,
        $list_image,
        $author,
        $full_content,
        $short_content,
        $status
    );
}

