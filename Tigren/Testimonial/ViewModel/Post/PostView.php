<?php declare(strict_types=1);

namespace Tigren\Testimonial\ViewModel\Post;

use Tigren\Testimonial\Model\Post;
use Tigren\Testimonial\Model\ResourceModel\Post\Collection;
use Tigren\Testimonial\Model\ResourceModel\Post\CollectionFactory;
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
        $collection->addFieldToFilter('entity_id', (int)$this->request->getParam('entity_id'));

        return $collection->getFirstItem();
    }
    public function getPostImage(Post $post): string
    {
        $fileName = $post->getData('profile_image');

        $imgPath = 'tmp/imageUploader/images';
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . $imgPath . '/' . $fileName;
    }


}
