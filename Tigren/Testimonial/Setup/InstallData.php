<?php

namespace Tigren\Testimonial\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute(Customer::ENTITY, 'is_created_testimonial');
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'is_created_testimonial',
            [
                'type'         => 'int',
                'label'        => 'Is Created Testimonial',
                'input'        => 'boolean',
                'required'     => false,
                'visible'      => true,
                'user_defined' => true,
                'position'     => 1000,
                'system'       => 0,
                'default'      => 0, // false
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit']
            ]
        );

        $customAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'is_created_testimonial');
        $customAttribute->setData('used_in_forms', ['adminhtml_customer', 'customer_account_edit']);
        $customAttribute->save();
    }
}
