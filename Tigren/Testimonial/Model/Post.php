<?php
namespace Tigren\Testimonial\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Tigren\Testimonial\Model\ResourceModel\Post');
	}
}
