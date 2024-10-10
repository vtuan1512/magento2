<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Blog\Model\Api;

use Tigren\Blog\Api\CustomInterface;
use Tigren\Blog\Model\ResourceModel\Post\CollectionFactory;
use Tigren\Blog\Model\PostFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Tigren\Blog\Model\ResourceModel\Post as BlogResource;

/**
 *
 */
class Custom implements CustomInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var BlogResource
     */
    private $blogResource;

    /**
     * @param CollectionFactory $collectionFactory
     * @param PostFactory $postFactory
     * @param BlogResource $blogResource
     */
    public function __construct(CollectionFactory $collectionFactory, PostFactory $postFactory, BlogResource $blogResource)
    {
        $this->collectionFactory = $collectionFactory;
        $this->postFactory = $postFactory;
        $this->blogResource = $blogResource;
    }

    /**
     * @return array
     */
    public function getAllPosts()
    {
        $collection = $this->collectionFactory->create();
        $posts = [];
        foreach ($collection as $post) {
            $posts[] = $this->mapPostData($post);
        }

        return $posts;
    }

    /**
     * @param $id
     * @return array
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $post = $this->postFactory->create()->load($id);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $id));
        }

        return $this->mapPostData($post);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        $post = $this->postFactory->create()->load($id);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $id));
        }

        $post->setStatus(0);
        $post->save();
        return 'Post successfully deleted';
    }

    /**
     * @param $title
     * @param $cate_id
     * @param $post_image
     * @param $list_image
     * @param $author
     * @param $full_content
     * @param $short_content
     * @param $status
     * @return string
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function insert($title, $cate_id, $post_image, $list_image, $author, $full_content, $short_content, $status)
    {
        $blog = $this->postFactory->create();
        $blog->setTitle($title);
        $blog->setCateId($cate_id);
        $blog->setPostImage($post_image);
        $blog->setListImage($list_image);
        $blog->setAuthor($author);
        $blog->setFullContent($full_content);
        $blog->setShortContent($short_content);
        $blog->setStatus($status);

        $this->blogResource->save($blog);

        return "Insert Successful";
    }

    /**
     * @param $post_id
     * @param $title
     * @param $cate_id
     * @param $post_image
     * @param $list_image
     * @param $author
     * @param $full_content
     * @param $short_content
     * @param $status
     * @return string
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateById($post_id, $title, $cate_id, $post_image, $list_image, $author, $full_content, $short_content, $status)
    {
        $blog = $this->postFactory->create();
        $this->blogResource->load($blog, $post_id);

        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Can not find post with ID %1', $post_id));
        }

        $blog->setTitle($title);
        $blog->setCateId($cate_id);
        $blog->setPostImage($post_image);
        $blog->setListImage($list_image);
        $blog->setAuthor($author);
        $blog->setFullContent($full_content);
        $blog->setShortContent($short_content);
        $blog->setStatus($status);

        $this->blogResource->save($blog);

        return "update success.";
    }

    /**
     * @param $post
     * @return array
     */
    private function mapPostData($post)
    {
        return [
            'post_id' => $post->getPostId(),
            'title' => $post->getTitle(),
            'cate_id' => $post->getCateId(),
            'post_image' => $post->getPostImage(),
            'list_image' => $post->getListImage(),
            'full_content' => $post->getFullContent(),
            'short_content' => $post->getShortContent(),
            'author' => $post->getAuthor(),
            'status' => $post->getStatus(),
            'published_at' => $post->getPublishedAt(),
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt()
        ];
    }
}
