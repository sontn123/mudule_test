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
class MassEnable extends \Magento\Backend\App\Action implements HttpPostActionInterface
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
        $selected = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
//        var_dump($this->getRequest()->getParams());
//        var_dump($selected);die;
        $collection->addFieldToFilter('post_id',['in' => $selected]);
        //var_dump($collection);
        $collectionSize = $collection->getSize();
        //var_dump($collectionSize);die;
        foreach ($collection as $post){
            $post->setStatus(true);
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
            __('A total of %1 record(s) have been enable.', $collectionSize)
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
