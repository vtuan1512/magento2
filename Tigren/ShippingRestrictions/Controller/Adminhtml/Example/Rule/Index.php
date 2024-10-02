<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule;

class Index extends \Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule
{
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Tigren Shipping Restrictions Rules'), __('Tigren Shipping Restrictions Rules'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Tigren Shipping Restrictions Rules'));
        $this->_view->renderLayout('root');
    }
}
