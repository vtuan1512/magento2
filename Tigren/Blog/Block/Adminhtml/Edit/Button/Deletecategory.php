<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Blog\Block\Adminhtml\Edit\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Deletecategory extends Generic implements ButtonProviderInterface
{
    protected $context;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getButtonData()
    {
        $data = [];
        $id = $this->context->getRequest()->getParam('id');
        if ($id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to delete this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        $id = $this->context->getRequest()->getParam('id');
        return $this->getUrl('*/*/deletecategory', ['id' => $id]);
    }
}
