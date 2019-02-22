<?php
namespace Ecommage\HelloWorld\Block;
class Test extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Ecommage\HelloWorld\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }
    public function getPostData(){
        $post = $this->_postFactory->create()->getCollection();
        return $post;
    }
}