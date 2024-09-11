<?php
namespace Tigren\Faq\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tigren\Faq\Model\Post', 'Tigren\Faq\Model\ResourceModel\Post');
	}

}
