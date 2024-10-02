<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Block\Adminhtml\Example\Rule\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Conditions extends Generic implements TabInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
     */
    protected $rendererFieldset;

    /**
     * @var \Magento\Rule\Block\Conditions
     */
    protected $conditions;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Rule\Block\Conditions $conditions
     * @param \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Rule\Block\Conditions $conditions,
        \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset,
        array $data = []
    ) {
        $this->rendererFieldset = $rendererFieldset;
        $this->conditions = $conditions;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Conditions');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Conditions');
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

        $renderer = $this->rendererFieldset->setTemplate(
            'Magento_CatalogRule::promo/fieldset.phtml'
        )->setNewChildUrl(
            $this->getUrl('tigrenshippingrestrictions/example_rule/newConditionHtml/form/rule_conditions_fieldset')
        );

        $fieldset = $form->addFieldset(
            'conditions_fieldset',
            [
                'legend' => __(
                    'Apply the rule only if the following conditions are met (leave blank for all products).',

                )
            ]
        )->setRenderer(
            $renderer
        );

        $fieldset->addField(
            'conditions',
            'text',
            ['name' => 'conditions', 'label' => __('Conditions'), 'title' => __('Conditions')]
        )->setRule(
            $model
        )->setRenderer(
            $this->conditions
        );

        $fieldset2 = $form->addFieldset(
            'conditions_fieldset2',
            [
                'legend' => __(
                    'Apply the rule depending on Cart Price Rule (This will override the condition above).'
                )
            ]
        )->setRenderer(
            $renderer
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $ruleCollection = $objectManager->get('\Magento\SalesRule\Model\ResourceModel\Rule\Collection');

        $ruleOptions = [];
        $ruleOptions[] = [
            'value' => '',
            'label' => __('~~ Please Select ~~')
        ];

        foreach ($ruleCollection as $rule) {
            $ruleOptions[] = [
                'value' => $rule->getId(),
                'label' => $rule->getName()
            ];
        }

        $fieldset2->addField(
            'active_cart',
            'multiselect',
            [
                'name' => 'active_cart[]',
                'label' => __('Active if these Cart Price Rules are applied'),
                'title' => __('Active if these Cart Price Rules are applied'),
                'values' => $ruleOptions,
                'disabled' => false,
            ]
        );
        $fieldset2->addField(
            'inactive_cart',
            'multiselect',
            [
                'name' => 'inactive_cart[]',
                'label' => __('Inactive if these Cart Price Rule are applied'),
                'title' => __('Inactive if these Cart Price Rule are applied'),
                'values' => $ruleOptions,
                'disabled' => false,
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
