<?php

namespace Tigren\Faq\Controller\Adminhtml\Post;

class Deletepost extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $postFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Tigren\Faq\Model\PostFactory $postFactory
	)
	{
		$this->postFactory = $postFactory;
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{

        $resultRedirect = $this->resultRedirectFactory->create();
        $id=$this->getRequest()->getParam('id');
       // echo $id; exit;
	     try{
	           	   $model = $this->postFactory->create()->load($id);
				   $model->delete();
		    	$this->messageManager->addSuccessMessage(__('You have deleted the question.'));
			}catch(\Exception $e){
				 $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the question.'));
			}
	 return $resultRedirect->setPath('*/*/');
	}


}
