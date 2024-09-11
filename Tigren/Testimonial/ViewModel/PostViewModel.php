<?php
declare(strict_types=1);

namespace Tigren\Testimonial\ViewModel;

use Tigren\Testimonial\Model\Post;
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
        return $this->url->getBaseUrl() . 'testimonial/' . $post->getData('entity_id');
    }

    public function getPostImage(Post $post): string
    {
        $fileName = $post->getData('profile_image');

        $imgPath = 'tmp/imageUploader/images';
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . $imgPath . '/' . $fileName;
    }
}
