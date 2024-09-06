<?php
namespace Tigren\Blog\Model;

use AllowDynamicProperties;
use Tigren\Blog\Model\ResourceModel\Category\CollectionFactory;

#[AllowDynamicProperties] class DataProviderCate extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $categoryCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $categoryCollectionFactory->create();
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
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $blog) {
            $this->loadedData[$blog->getId()] = $blog->getData();
        }
        return $this->loadedData;
    }
}
