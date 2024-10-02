<?php
namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tigren\CustomerGroupCatalog\Model\RuleHistory', 'Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory');
	}


}
