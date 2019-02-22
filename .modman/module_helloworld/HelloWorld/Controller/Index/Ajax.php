<?php
namespace Ecommage\HelloWorld\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
//use Ecommage\HelloWorld\Block\Index;

class Ajax extends Action {

    const PAGE_SIZE = 3;

    protected $_postFactory;

    public function __construct(Context $context,array $data = [],\Ecommage\HelloWorld\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }
    public function execute() {
//        $data = array("a");
////        var_dump($this->_request->getParam('current_page'));die;
////        $data = $this->getRequest()->getParams();
////        var_dump($data);die;
//        $i = $this->_request->getParam('current_page');
////        var_dump($i); die;
        $i = $this->getRequest()->getParam('current_page');
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData([
            'content' => $this->_view->getLayout()
                ->createBlock(
                    'Ecommage\HelloWorld\Block\Index',
                    "block_namedsadsa",
                    [
                        'data' => [
                            'current_page' => $i+1,
                            'isAjax'    => true
                        ]
                    ]
                    )
                ->setTemplate('Ecommage_HelloWorld::index.phtml')
                ->toHtml(),
            'current_page' => $i+1,
            'status' => 'OK'

        ]);
//
////        var_dump($resultJson);die;
////        $post = $this->_postFactory->create();
////        $data = $post->getCollection();
//
//       if ($i > $this->maxPage()) {
//
//       }
//        $data->setPageSize(Index::PAGE_SIZE);
//
//        $data->setCurPage($i+1);
//
//        return $resultJson;

//        var_dump($i);die;


        return $resultJson;
    }

    protected function maxPage()
    {
        $collection = $this->_postFactory->create()->getCollection();
        $m = $collection->getSize();
        $p = ceil($m/Index::PAGE_SIZE);
        return $p;
    }

}