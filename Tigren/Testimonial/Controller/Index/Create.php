<?php

declare(strict_types=1);

namespace Tigren\Testimonial\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Create implements HttpGetActionInterface
{
    public function __construct(private PageFactory $pageFactory)
    {}

    public function execute(): ResultInterface
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__('Add new Testimonial'));

        return $page;
    }
}
