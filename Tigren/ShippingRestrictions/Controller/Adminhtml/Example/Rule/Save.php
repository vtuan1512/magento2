<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule;

class Save extends \Tigren\ShippingRestrictions\Controller\Adminhtml\Example\Rule
{

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Tigren\ShippingRestrictions\Model\RuleFactory $ruleFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Tigren\ShippingRestrictions\Model\RuleFactory $ruleFactory,
        \Psr\Log\LoggerInterface $logger
    ) {

        parent::__construct($context, $coreRegistry, $fileFactory, $dateFilter, $ruleFactory, $logger);
    }

    /**
     * Rule save action
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->getRequest()->getPostValue()) {
            $this->_redirect('tigrenshippingrestrictions/*/');
        }

        try {
            /** @var $model \Tigren\ShippingRestrictions\Model\Rule */
            $model = $this->ruleFactory->create();
            $this->_eventManager->dispatch(
                'adminhtml_controller_vendor_rules_prepare_save',
                ['request' => $this->getRequest()]
            );
            $data = $this->getRequest()->getPostValue();
//            var_dump($data);die;
            $data['from_date'] = $this->dateFilter->filter($data['from_date']);
            $data['to_date'] = $this->dateFilter->filter($data['to_date']);
            $data['customer_group'] = implode(',', $data['customer_group']);
            $data['shipping_methods'] = implode(',', $data['shipping_methods']);
            $data['active_cart'] = implode(',', $data['active_cart']);
            $data['inactive_cart'] = implode(',', $data['inactive_cart']);

            $id = $this->getRequest()->getParam('rule_id');
            if ($id) {
                $model->load($id);
            }

            $validateResult = $model->validateData(new \Magento\Framework\DataObject($data));
            if ($validateResult !== true) {
                foreach ($validateResult as $errorMessage) {
                    $this->messageManager->addErrorMessage($errorMessage);
                }
                $this->_session->setPageData($data);
                $this->_redirect('tigrenshippingrestrictions/*/edit', ['id' => $model->getId()]);
                return;
            }

            $data = $this->prepareData($data);
//            var_dump($data);die;
            $model->loadPost($data);
//            var_dump($model);die;
            $this->_session->setPageData($model->getData());

            $model->save();
            $this->messageManager->addSuccessMessage(__('You saved the rule.'));
            $this->_session->setPageData(false);
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('tigrenshippingrestrictions/*/edit', ['id' => $model->getId()]);
                return;
            }
            $this->_redirect('tigrenshippingrestrictions/*/');
            return;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $id = (int)$this->getRequest()->getParam('rule_id');
            if (!empty($id)) {
                $this->_redirect('tigrenshippingrestrictions/*/edit', ['id' => $id]);
            } else {
                $this->_redirect('tigrenshippingrestrictions/*/new');
            }
            return;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while saving the rule data. Please review the error log.')
            );
            $this->logger->critical($e);
            $data = !empty($data) ? $data : [];
            $this->_session->setPageData($data);
            $this->_redirect('tigrenshippingrestrictions/*/edit', ['id' => $this->getRequest()->getParam('rule_id')]);
            return;
        }
    }

    /**
     * Prepares specific data
     *
     * @param array $data
     * @return array
     */
    protected function prepareData($data)
    {

        if (isset($data['rule']['conditions'])) {
            $data['conditions'] = $data['rule']['conditions'];
        }

        unset($data['rule']);

        return $data;
    }
}
