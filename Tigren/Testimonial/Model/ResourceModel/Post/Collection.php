<?php
namespace Tigren\Testimonial\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tigren\Testimonial\Model\Post', 'Tigren\Testimonial\Model\ResourceModel\Post');
	}

}
