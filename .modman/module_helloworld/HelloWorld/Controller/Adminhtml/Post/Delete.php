<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{
    protected $_postFactory;

    public function __construct(Action\Context $context,\Ecommage\HelloWorld\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    //const ADMIN_RESOURCE = 'Ecomage_HelloWorld::post';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('post_id');
        //var_dump($id);die;
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        //var_dump($id); die;
        if ($id){
                $model = $this->_postFactory->create();
//                var_dump($model); die;
                $model->load($id);
                //var_dump($model) ;die;
                $model->delete();
                return $resultRedirect->setPath('*/*/');
        }
//        if ($id) {
//            $title = "";
//            try {
//                // init model and delete
//                $model = $this->_objectManager->create(\Ecommage\HelloWorld\Model\Post::class);
//                $model->load($id);
//
//                $title = $model->getTitle();
//                $model->delete();
//
//                // display success message
//                $this->messageManager->addSuccessMessage(__('The page has been deleted.'));
//
//                // go to grid
//                $this->_eventManager->dispatch('adminhtml_cmspage_on_delete', [
//                    'title' => $title,
//                    'status' => 'success'
//                ]);
//
//                return $resultRedirect->setPath('*/*/');
//            } catch (\Exception $e) {
//                $this->_eventManager->dispatch(
//                    'adminhtml_cmspage_on_delete',
//                    ['title' => $title, 'status' => 'fail']
//                );
//                // display error message
//                $this->messageManager->addErrorMessage($e->getMessage());
//                // go back to edit form
//                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
//            }
//        }

        // display error message
        //$this->messageManager->addErrorMessage(__('We can\'t find a post to delete.'));

        // go to grid
        //return $resultRedirect->setPath('*/*/');
    }
}
