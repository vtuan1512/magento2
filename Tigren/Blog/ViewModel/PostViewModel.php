<?php
declare(strict_types=1);

namespace Tigren\Blog\ViewModel;

use Tigren\Blog\Model\Post;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class PostViewModel implements ArgumentInterface
{
    public function __construct(
        private UrlInterface $url,
        private StoreManagerInterface $storeManager
    ) {}

    public function getPostUrl(Post $post): string
    {
        return $this->url->getBaseUrl() . 'blog/' . $post->getData('post_id');
    }

    public function getPostImage(Post $post): string
    {
        $fileName = $post->getData('post_image');

        $imgPath = 'tmp/imageUploader/images';
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . $imgPath . '/' . $fileName;
    }
}
