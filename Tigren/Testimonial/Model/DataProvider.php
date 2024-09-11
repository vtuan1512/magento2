<?php
namespace Tigren\Testimonial\Model;

use AllowDynamicProperties;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Tigren\Testimonial\Model\ResourceModel\Post\CollectionFactory;

#[AllowDynamicProperties]
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $mediaDirectory;
    protected $mime;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        RequestInterface $request,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->request = $request;
        $this->mediaDirectory = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->mime = new \finfo(FILEINFO_MIME_TYPE);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $items = $this->collection->getItems();
        $this->loadedData = [];

        /** @var \Tigren\Testimonial\Model\Post $post */
        foreach ($items as $post) {
            $postData = $post->getData();
            $image = $postData['profile_image'] ?? null;
            if ($image) {
                $imgDir = 'tmp/imageUploader/images';
                $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $fullImagePath = $this->mediaDirectory->getAbsolutePath($imgDir) . '/' . $image;
                if ($this->mediaDirectory->isFile($fullImagePath)) {
                    $imageUrl = $baseUrl . $imgDir . '/' . $image;
                    $stat = $this->mediaDirectory->stat($fullImagePath);
                    $mimeType = $this->mime->file($fullImagePath);
                    $postData['profile_image'] = [
                        [
                            'url' => $imageUrl,
                            'name' => $image,
                            'size' => $stat['size'],
                            'type' => $mimeType
                        ]
                    ];
                } else {
                    $postData['profile_image'] = null;
                }
            }
            $this->loadedData[$post->getId()] = $postData;
        }
        return $this->loadedData;
    }
}
