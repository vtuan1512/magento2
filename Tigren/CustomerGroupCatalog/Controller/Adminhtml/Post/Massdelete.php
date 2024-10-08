<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\CollectionFactory;
use Tigren\CustomerGroupCatalog\Model\PostFactory;

class Massdelete extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $postFactory;

	public $collectionFactory;

    public $filter;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
	 	Filter $filter,
        CollectionFactory $collectionFactory,
        PostFactory $postFactory
	)
	{
		parent::__construct($context);
		$this->postFactory = $postFactory;
	 	$this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
	    $ids=$this->getRequest()->getParams();
		 try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;

            foreach ($collection as $model) {
                $model = $this->postFactory->create()->load($model->getId());
                $model->delete();
                $count++;
            }

            $this->messageManager->addSuccess(__('A total of %1 blog(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
	}


}
