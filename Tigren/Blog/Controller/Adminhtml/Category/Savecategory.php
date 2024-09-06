<?php

namespace Tigren\Blog\Controller\Adminhtml\Category;

class Savecategory extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $categoryFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Tigren\Blog\Model\CategoryFactory $categoryFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Sửa đổi tại đây, sử dụng getPostValue để lấy dữ liệu từ form POST
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('cate_id');

        try {
            /** @var \Magento\Cms\Model\Page $model */
            if (isset($id) && !empty($id)) {
                unset($data['cate_id']);
                $model = $this->categoryFactory->create()->load($id);
                $model->addData($data);
                $model->save();
            } else {
                unset($data['cate_id']);
                $model = $this->categoryFactory->create();
                $model->setData($data);
                $model->save();
            }
            $this->messageManager->addSuccessMessage(__('You saved the category.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the category.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}

