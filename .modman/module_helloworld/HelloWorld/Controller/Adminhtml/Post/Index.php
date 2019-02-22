<?php
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {

        // TODO: Implement execute() method.
        $resultPage = $this->resultPageFactory->create();
        //$resultPage->setActiveMenu('Ecommage_HelloWorld::helloworld');
        $resultPage->getConfig()->getTitle()->prepend((__('Posts')));

        return $resultPage;
    }
}