<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Block\Adminhtml\Example\Rule\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Action extends Generic implements TabInterface
{

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Actions');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Actions');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Generic
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_rule');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('rule_');

        $fieldset = $form->addFieldset('actions_fieldset', ['legend' => __('Actions')]);

        if ($model->getId()) {
            $fieldset->addField('rule_id', 'hidden', ['name' => 'rule_id']);
        }

        $fieldset->addField(
            'what_to_do',
            'select',
            [
                'label' => __('What to do'),
                'title' => __('What to do'),
                'name' => 'what_to_do',
                'required' => false,
                'options' => ['0' => __('Show'), '1' => __('Hide')]
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $shippingConfig = $objectManager->get('\Magento\Shipping\Model\Config');
        $activeCarriers = $shippingConfig->getActiveCarriers();

        $shippingMethods = [];
        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                $carrierTitle = $this->_scopeConfig->getValue('carriers/' . $carrierCode . '/title');
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode . '_' . $methodCode;
                    $shippingMethods[] = ['value' => $code, 'label' => $carrierTitle . ' - ' . $method];
                }
            }
        }

        $fieldset->addField(
            'shipping_methods',
            'multiselect',
            [
                'label' => __('Select Shipping Methods'),
                'title' => __('Select Shipping Methods'),
                'name' => 'shipping_methods[]',
                'required' => false,
                'values' => $shippingMethods,
                'disabled' => false,
            ]
        );

        $form->setValues($model->getData());

        if ($model->isReadonly()) {
            foreach ($fieldset->getElements() as $element) {
                $element->setReadonly(true, true);
            }
        }

        $this->setForm($form);

        $this->_eventManager->dispatch('adminhtml_example_rule_edit_tab_action_prepare_form', ['form' => $form]);

        return parent::_prepareForm();
    }
}
