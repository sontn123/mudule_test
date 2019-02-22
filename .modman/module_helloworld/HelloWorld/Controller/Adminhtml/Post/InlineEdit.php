<?php
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Ecommage\HelloWorld\Model\PostFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Cms\Api\PageRepositoryInterface as PageRepository;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $_postFactory;
    protected $_jsonFactory;

    public function __construct(Action\Context $context,PostFactory $postFactory,JsonFactory $jsonFactory)
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        // TODO: Implement execute() method.
        if (!($this->getRequest()->getParam('isAjax'))) {
            return $this->serialize([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }else{
            $data = $this->getRequest()->getParam('items',[]);
            //var_dump($data);die;

            // lay du lieu ben trong cung co 2 cach array_shift || reset

            $data = array_shift($data);
//        var_dump($data);die;
//        var_dump(reset($data)); die;
//        $tmp = array_keys($data);
            $model = $this->_postFactory->create();
            $model->setData($data);
            $model->save();
            $dataRespon = ['messages' => 'edit record susscess',
                            'error'   => false,
                ];
//            $resultRedirect = $this->resultRedirectFactory->create();
//
//            $result = $this->serialize($dataRespon);
            
            return $resultJson->setData($dataRespon);
        }

    }
    public function serialize($data)
    {
        $result = json_encode($data);
        if (false === $result) {
            throw new \InvalidArgumentException('Unable to serialize value.');
        }
        return $result;
    }
}