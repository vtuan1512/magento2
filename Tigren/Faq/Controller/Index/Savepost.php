<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Faq\Controller\Index;

use AllowDynamicProperties;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Tigren\Faq\Model\PostFactory;

#[AllowDynamicProperties] class Savepost extends Action
{
    protected $resultJsonFactory;
    protected $saveFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        PostFactory $saveFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->saveFactory = $saveFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = $this->getRequest()->getPostValue();
//        var_dump($data);die;
        if (!empty($data['question']) && !empty($data['name']) && !empty($data['product'])) {
            $model = $this->saveFactory->create();
            $model->setData('question', $data['question']);
            $model->setData('author', $data['name']);
            $model->setData('product', $data['product']);
            try {
                $model->save();
                return $result->setData(['success' => true, 'message' => 'Question submitted successfully.']);
            } catch (\Exception $e) {
                return $result->setData(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        return $result->setData(['success' => false, 'message' => 'Invalid data.']);
    }
}
