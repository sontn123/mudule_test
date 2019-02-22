<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ecommage\HelloWorld\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * @api
 * @since 100.0.2
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
//    const NAME = 'thumbnail';
//
//    const ALT_FIELD = 'name';
    public $_storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
//        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
//        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
//        var_dump($dataSource['data']['items']);die;
//        $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
//        var_dump($baseUrl);die;
//        var_dump($dataSource['data']['items']);die;
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            //var_dump($fieldName);die;
            foreach ($dataSource['data']['items'] as & $item) {
//                var_dump($item);die;
                //$product = new \Magento\Framework\DataObject($item);
//                $imageHelper = $this->imageHelper->init($product, 'product_listing_thumbnail');
                $item[$fieldName . '_src'] = $baseUrl . 'helloworld/post/'. $item['featured_image'] ;
//                var_dump($item[$fieldName . '_src']);die;
//                var_dump($item);die;
                $item[$fieldName . '_alt'] = $item['name'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'ecommage_helloworld/post/edit',
                    ['post_id' => $item['post_id'], 'store' => $this->context->getRequestParam('store')]
                );
//                $origImageHelper = $this->imageHelper->init($product, 'product_listing_thumbnail_preview');
//                $item[$fieldName . '_orig_src'] = $origImageHelper->getUrl();
                $item[$fieldName . '_orig_src'] = $baseUrl . 'helloworld/post/'. $item['featured_image'] ;
            }
        }
        //var_dump($dataSource['data']['items']);die;
        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
