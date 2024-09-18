<?php
namespace Tigren\Testimonial\Block\Adminhtml\Tab;

use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\Store;

class Customergrid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    protected $customerCollFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context    $context
     * @param \Magento\Backend\Helper\Data               $backendHelper
     * @param \Magento\Customer\Model\CustomerFactory    $customerFactory
     * @param \Magento\Framework\Registry                $coreRegistry
     * @param \Magento\Framework\Module\Manager          $moduleManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array                                      $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerCollFactory = $customerCollFactory;
        $this->coreRegistry = $coreRegistry;
        $this->moduleManager = $moduleManager;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * [_construct description]
     * @return [type] [description]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('rh_grid_customers');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Get store id
     *
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * Prepare customer collection
     */
    protected function _prepareCollection()
    {
        $collection = $this->customerFactory->create()->getCollection()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('created_at');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add filters to the collection
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_customers') {
            $customerIds = $this->_getSelectedCustomers();
            if (empty($customerIds)) {
                $customerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $customerIds]);
            } else {
                if ($customerIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $customerIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_customers',
            [
                'type' => 'checkbox',
                'html_name' => 'customers_id',
                'required' => true,
                'values' => $this->_getSelectedCustomers(),
                'align' => 'center',
                'index' => 'entity_id',
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'width' => '50px',
                'index' => 'entity_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'firstname',
            [
                'header' => __('First Name'),
                'index' => 'firstname',
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type',
            ]
        );
        $this->addColumn(
            'lastname',
            [
                'header' => __('Last Name'),
                'index' => 'lastname',
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type',
            ]
        );
        $this->addColumn(
            'email',
            [
                'header' => __('Email'),
                'index' => 'email',
                'header_css_class' => 'col-email',
                'column_css_class' => 'col-email',
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'index' => 'created_at',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date',
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * Grid URL
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/index/grids', ['_current' => true]);
    }

    /**
     * Get selected customers
     */
    protected function _getSelectedCustomers()
    {
        $customers = array_keys($this->getSelectedCustomers());
        return $customers;
    }

    /**
     * Get selected customers array
     */
    public function getSelectedCustomers()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->customerCollFactory->create()->addFieldToFilter('entity_id', $id);
        $grids = [];
        foreach ($model as $key => $value) {
            $grids[] = $value->getId();
        }
        $customerId = [];
        foreach ($grids as $obj) {
            $customerId[$obj] = ['position' => "0"];
        }
        return $customerId;
    }
}
