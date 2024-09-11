<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Post;

class Savepost extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $postFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Tigren\Testimonial\Model\PostFactory $postFactory
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
        $id=$this->getRequest()->getParam('entity_id');
        if (!empty($data['profile_image'][0]['name']) && isset($data['profile_image'][0]['tmp_name'])) {
            $data['profile_image'] = $data['profile_image'][0]['name'];
        } else {
            unset($data['post_image']);
        }
	     try{
	        /** @var \Magento\Cms\Model\Page $model */
	           if(isset($id) && !empty($id)){
			   unset($data['entity_id']);
	           	   $model = $this->postFactory->create()->load($id);
				   $model->addData($data);
				   $model->save();
	           }else{
	         unset($data['entity_id']);
		       $model = $this->postFactory->create();
				   $model->setData($data);
				   $model->save();
			   }
		    	$this->messageManager->addSuccessMessage(__('You saved the testimonial.'));
			}catch(\Exception $e){
				 $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the testimonial.'));
			}
	 return $resultRedirect->setPath('*/*/');
	}


}
