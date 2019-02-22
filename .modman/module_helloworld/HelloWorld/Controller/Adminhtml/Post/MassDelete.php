<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommage\HelloWorld\Model\ResourceModel\Post\CollectionFactory;


/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    //const ADMIN_RESOURCE = 'Ecommage_HelloWorld::post';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        /** @var \Ecommage\HelloWorld\Model\ResourceModel\Post\Collection $collection */
        $collection = $this->collectionFactory->create();
        $selected = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
        //var_dump($selected);die;
        $excluded = $this->getRequest()->getParam(Filter::EXCLUDED_PARAM);
        $collection->addFieldToFilter('post_id', ['in' => $selected]);
        //var_dump($collection);die;
        $collectionSize = $collection->getSize();
        foreach ($collection as $post) {
            $post->delete();
        }

//
//
//        var_dump($collection->getData());die;
//
//        var_dump($selected);
//        var_dump($excluded); die;
//        $collection = $this->filter->getCollection($post);
//        var_dump($collection->getData()); die;
//        $collectionSize = $collection->getSize();
//        //var_dump($collectionSize);die();
//        foreach ($collection as $post) {
//            $post->delete();
//        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
