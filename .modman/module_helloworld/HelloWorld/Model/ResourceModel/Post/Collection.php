<?php
namespace Ecommage\HelloWorld\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Ecommage\HelloWorld\Model\Post','Ecommage\HelloWorld\Model\ResourceModel\Post');
    }
}