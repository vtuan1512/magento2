<?php
namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tigren\CustomerGroupCatalog\Model\Post', 'Tigren\CustomerGroupCatalog\Model\ResourceModel\Post');
	}


}
