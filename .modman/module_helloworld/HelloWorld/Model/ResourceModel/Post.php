<?php
namespace Ecommage\HelloWorld\Model\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context)
    {
        parent::__construct($context);
    }
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('ecommage_helloworld_posts','post_id');
    }
}