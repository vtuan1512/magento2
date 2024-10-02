<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Post;

class Savepost extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $postFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Tigren\CustomerGroupCatalog\Model\PostFactory $postFactory
	)
	{
		$this->postFactory = $postFactory;
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
        global $model;
        $data = $this->getRequest()->getPostValue();
      /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id=$this->getRequest()->getParam('rule_id');
	     try{
	        /** @var \Magento\Cms\Model\Page $model */
	           if(isset($id) && !empty($id)){
                   unset($data['rule_id']);
	           	   $model = $this->postFactory->create()->load($id);
//                   $productIds = isset($data['products']) ? $data['products'] : [];
//                   $model->setData('products', implode(',', $productIds));

                   $model->addData($data);
                   $model->save();
	           }else{
                   unset($data['rule_id']);
                   $model = $this->postFactory->create();
//                   $productIds = isset($data['products']) ? $data['products'] : [];
//                   $model->setData('products', implode(',', $productIds));
				   $model->setData($data);
				   $model->save();
			   }
		    	$this->messageManager->addSuccessMessage(__('You saved the Customer Group Catalog.'));
			}catch(\Exception $e){
				 $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Customer Group Catalog.'));
			}
	 return $resultRedirect->setPath('*/*/');
	}



}
