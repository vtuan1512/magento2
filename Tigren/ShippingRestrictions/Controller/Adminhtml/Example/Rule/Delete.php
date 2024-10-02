<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule;

class Delete extends \Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule
{
    /**
     * Delete rule action
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                /** @var \Tigren\ShippingRestrictions\Model\Rule $model */
                $model = $this->ruleFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the rule.'));
                $this->_redirect('tigrenshippingrestrictions/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete the rule right now. Please review the log and try again.')
                );
                $this->logger->critical($e);
                $this->_redirect('tigrenshippingrestrictions/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a rule to delete.'));
        $this->_redirect('tigrenshippingrestrictions/*/');
    }
}
