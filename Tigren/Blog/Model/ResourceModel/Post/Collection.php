<?php
namespace Tigren\Blog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tigren\Blog\Model\Post', 'Tigren\Blog\Model\ResourceModel\Post');
	}

}
