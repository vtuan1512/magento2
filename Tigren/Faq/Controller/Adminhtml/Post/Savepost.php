<?php

namespace Tigren\Faq\Controller\Adminhtml\Post;

class Savepost extends \Magento\Backend\App\Action
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
		$data = $this->getRequest()->getPostValue();
      /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id=$this->getRequest()->getParam('question_id');
        //echo $id; exit;
	     try{
	        /** @var \Magento\Cms\Model\Page $model */
	           if(isset($id) && !empty($id)){
			   unset($data['question_id']);
	           	   $model = $this->postFactory->create()->load($id);
				   $model->addData($data);
				   $model->save();
	           }else{
	         unset($data['question_id']);
		       $model = $this->postFactory->create();
				   $model->setData($data);
				   $model->save();
			   }
		    	$this->messageManager->addSuccessMessage(__('You saved the question.'));
			}catch(\Exception $e){
				 $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the question.'));
			}
	 return $resultRedirect->setPath('*/*/');
	}


}
