<?php

namespace Tigren\Testimonial\Ui\Component\Listing\Blog;

use Magento\Framework\View\Element\UiComponentFactory;

use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column {

    /**

     * @param ContextInterface $context

     * @param UiComponentFactory $uiComponentFactory

     * @param \Magento\Framework\UrlInterface $urlBuilder

     * @param array $components

     * @param array $data

     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['profile_image']) {
                    $imageUrl = $this->urlBuilder->getBaseUrl().'pub/media/tmp/imageUploader/images/'. $item['profile_image'];
                    $item[$fieldName . '_src'] = $imageUrl;
                    $item[$fieldName . '_alt'] = $item['profile_image'];
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        'blog/index/form',
                        ['id' => $item['entity_id']]);
                    $item[$fieldName . '_orig_src'] = $imageUrl;
                }
            }
        }
        return $dataSource;
    }
}
