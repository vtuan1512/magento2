<?php declare(strict_types=1);

namespace Tigren\Blog\ViewModel\Post;

use Tigren\Blog\Model\Post;
use Tigren\Blog\Model\ResourceModel\Post\Collection;
use Tigren\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class PostView implements ArgumentInterface
{
    public function __construct(
        private RequestInterface $request,
        private CollectionFactory $collectionFactory,
        private StoreManagerInterface $storeManager
    ) {
    }

    public function getPost(): Post
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('post_id', (int)$this->request->getParam('post_id'));

        return $collection->getFirstItem();
    }
    public function getPostImage(Post $post): string
    {
        $fileName = $post->getData('post_image');

        $imgPath = 'tmp/imageUploader/images';
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . $imgPath . '/' . $fileName;
    }


}
