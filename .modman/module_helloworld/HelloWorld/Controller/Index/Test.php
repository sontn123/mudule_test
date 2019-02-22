<?php
namespace Ecommage\HelloWorld\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_postFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Ecommage\HelloWorld\Model\PostFactory $postFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
