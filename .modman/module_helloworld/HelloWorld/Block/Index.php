<?php
namespace Ecommage\HelloWorld\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    const PAGE_SIZE = 3;


    protected $_postFactory;

    protected $_image;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ecommage\HelloWorld\Model\PostFactory $postFactory,
        array $data = []
    ) {
        $this->_postFactory = $postFactory;
        if (!isset($data['current_page'])) {
            $data['current_page'] = 1;
        }
        parent::__construct($context);
    }
    public function getPostCollection(){
        $post = $this->_postFactory->create();
        $data = $post->getCollection();
        $data->setPageSize(self::PAGE_SIZE);
        $data->setCurPage($this->getCurrentPage());
//        var_dump($data->getData());die;$this->getCurrentPage()
        return $data;
    }

}