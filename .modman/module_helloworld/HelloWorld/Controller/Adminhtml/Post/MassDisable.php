<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommage\HelloWorld\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class MassDisable
 */
class MassDisable extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    //const ADMIN_RESOURCE = 'Magento_Cms::save';

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
        $collection = $this->collectionFactory->create();
        //var_dump($collection);die;
        //$collection = $this->getCollection($collection);
        //var_dump($collection->getData()); die;
        $selected = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
        //$excluded = $this->request->getParam(static::EXCLUDED_PARAM);

//        $selected = $this->getRequest()->getParam('post_id');
//        var_dump($this->getRequest()->getParams());
        //var_dump($selected);die;
        $collection->addFieldToFilter('post_id',['in' => $selected]);
        //var_dump($collection);
        $collectionSize = $collection->getSize();
        //var_dump($collectionSize);die;
        foreach ($collection as $post){
            $post->setStatus(false);
            $post->save();
        }

//        $collection = $this->filter->getCollection($this->collectionFactory->create());
//        //var_dump($collection);die;
//        foreach ($collection as $item) {
//            //var_dump($item); die;
//            $item->setIsActive(false);
//            $item->save();
//        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been disabled.', $collectionSize)
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
//    public function getCollection($collection)
//    {
//        $selected = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
//        $excluded = $this->getRequest()->getParam(Filter::EXCLUDED_PARAM);
//
//        $isExcludedIdsValid = (is_array($excluded) && !empty($excluded));
//        $isSelectedIdsValid = (is_array($selected) && !empty($selected));
//
//        if ('false' !== $excluded) {
//            if (!$isExcludedIdsValid && !$isSelectedIdsValid) {
//                throw new LocalizedException(__('An item needs to be selected. Select and try again.'));
//            }
//        }
//        var_dump($selected);
//        var_dump($excluded);die;
//        $collection->addFieldToFilter(
//            $collection->getIdFieldName(),
//            ['in' => $this->getFilterIds()]
//        );
//
//        return $collection;
//    }
}
