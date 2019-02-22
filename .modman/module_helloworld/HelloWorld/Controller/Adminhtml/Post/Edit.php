<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    //const ADMIN_RESOURCE = 'Magento_Cms::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance(); //instance of\Magento\Framework\App\ObjectManager


        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Ecommage_HelloWorld::post')
//            ->addBreadcrumb(__('HelloWorld'), __('HelloWorld'))
//            ->addBreadcrumb(__('Manage Posts'), __('Manage Posts'));
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('post_id');
        //var_dump($id);die;
        $model = $this->_objectManager->create(\Ecommage\HelloWorld\Model\Post::class);
        if ($this->getRequest()->getParam('duplicate') != null){
//            $duplicate = $this->getRequest()->getParam('duplicate');
            $id = $this->getRequest()->getParam('post_id');
            $model->load($id);
            $model->setPostId(null);
            $model->save();
        }
        // 2. Initial checking
        if ($id) {
            $model->load($id);
//            $fileName = $model->getFeaturedImage();
//            $baseUrl = $this->getMediaUrl();
            //var_dump($baseUrl);die;
//            $img = $model->getFeaturedImage();
//            var_dump($img);die;
//            $model->setFeaturedImage($baseUrl.'helloworld/post/'.$img);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('current_post', $model);
        //var_dump($this->_coreRegistry->registry('current_post'));die;
        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */

        $resultPage = $this->_initAction();

        $resultPage->addBreadcrumb(
            $id ? __('Edit Post') : __('New Post'),
            $id ? __('Edit Post') : __('New Post')
        );
        //var_dump($resultPage); die;
        $resultPage->getConfig()->getTitle()->prepend(__('Posts'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getPostId() ? $model->getName() : __('New Post'));
        //var_dump($resultPage); die;
        return $resultPage;
    }
    public function getMediaUrl(){
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance(); //instance of\Magento\Framework\App\ObjectManager
        $storeManager = $_objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $currentStore = $storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}
