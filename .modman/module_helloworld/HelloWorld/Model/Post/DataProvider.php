<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Model\Post;

use Ecommage\HelloWorld\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        DataPersistorInterface $dataPersistor,
//        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
//        $this->_storeManager = $storeManager;
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
//        $baseUrl = $this->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);


        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
//        var_dump($items);die;
        /** @var $page \Magento\Cms\Model\Page */
        foreach ($items as $page) {
//            var_dump($page->getImageUrl());
//            var_dump(get_class_methods($page)); die;
            $baseUrl = $page->getImageUrl();
//            var_dump($baseUrl);die;
            //var_dump($page);die;
            $temp = $page->getData();
//            var_dump($temp);die;
            $postId = $temp['post_id'];
            if (isset($temp)){

                $this->loadedData[$postId] = $temp;

//                var_dump($this->loadedData[$postId]['featured_image']);die;
                $img[0] = [
                    'url' => $baseUrl . $this->loadedData[$postId]['featured_image'],
                    'name' => $this->loadedData[$postId]['featured_image']
                ];
//                var_dump($img);die;
                $this->loadedData[$postId]['featured_image'] = $img;
            }
//            $this->loadedData[$page->getId()] = $page->getData();
        }
//        var_dump($this->loadedData);die;
        $data = $this->dataPersistor->get('ecommage_helloworld_post');
//        $data = $this->dataPersistor->get('page');
//        var_dump($data);die;
        //var_dump($data); die;
        if (!empty($data)) {
            $page = $this->collection->getNewEmptyItem();
            $page->setData($data);
            $this->loadedData[$page->getId()] = $page->getData();
            $this->dataPersistor->clear('ecommage_helloworld_post');
        }
//        var_dump($this->loadedData[3]);die;
        return $this->loadedData;
    }
}
