<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule;

class NewAction extends \Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule
{
    /**
     * New action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
