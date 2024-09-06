<?php

namespace Tigren\Blog\Controller\Adminhtml\Category;

class Deletecategory extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $categoryFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Tigren\Blog\Model\CategoryFactory $categoryFactory
    )
    {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();
        $id=$this->getRequest()->getParam('id');
        // echo $id; exit;
        try{
            $model = $this->categoryFactory->create()->load($id);
            $model->delete();
            $this->messageManager->addSuccessMessage(__('You have deleted the category.'));
        }catch(\Exception $e){
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the category.'));
        }
        return $resultRedirect->setPath('*/*/');
    }


}
