<?php
namespace Ecommage\HelloWorld\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Ecommage_HelloWorld::helloworld';
    protected $dataProcessor;
    protected $dataPersistor;
    protected $imageUploader;
    protected $_postFactory;
    protected $_postRepository;
    protected $_fileUploader;


    public function __construct(Action\Context $context,
                                \Ecommage\HelloWorld\Model\PostFactory $postFactory = null,
                                PostDataProcessor $dataProcessor,
                                DataPersistorInterface $dataPersistor
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        //$this->_fileUploader = $fileUploaderFactory;
        $this->_postFactory = $postFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Ecommage\HelloWorld\Model\PostFactory::class);
//        $this->_postRepository = $postRepository
//            ?: \Magento\Framework\App\ObjectManager::getInstance()
//                ->get(\Ecommage\HelloWorld\Api\PostRepositoryInterface::class);
        parent::__construct($context);
    }
    public function execute()
    {
        // TODO: Implement execute() method.
        $data = $this->getRequest()->getPostValue();
//        var_dump($data);
        $id = (int)$this->getRequest()->getParam('post_id');
        $model = $this->_postFactory->create();
        //var_dump($model);die;
        $resultRedirect = $this->resultRedirectFactory->create();

        //$this->processResultRedirect($model,$resultRedirect,$data);

        try {
            $msg = __('add record success');
            if ($id) {
                $msg = __('Edit record success');
            }

            if (isset($data['post_id']) && !$id) {
                unset($data['post_id']);
            }

            $model->setData($data);
            $model->setUrlKey($model->beforeSave());

            //save image

            if (isset($data['featured_image'][0]['name']) && isset($data['featured_image'][0]['tmp_name'])) {
                $data['image'] = $data['featured_image'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                    'Ecommage\HelloWorld\HelloWorldImageUpload'
                );
                //var_dump($data['image']);die;
                //var_dump($this->imageUploader->moveFileFromTmp($data['featured_image']));die;
                $this->imageUploader->moveFileFromTmp($data['image']);
            } elseif (isset($data['featured_image'][0]['file']) && !isset($data['featured_image'][0]['tmp_name'])) {
                $data['image'] = $data['featured_image'][0]['file'];
            } else {
                $data['image'] = 'default.jpeg';
            }
            $model->setFeaturedImage($data['image']);
//            var_dump($data['image']);die;

            $model->save();
//            var_dump($model);die;
            $this->messageManager->addSuccessMessage($msg);
        } catch (LocalizedException $e){
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        if ($this->getRequest()->getParam('back', false) === 'duplicate'){
            return $resultRedirect->setPath('*/*/edit',['post_id' => $model->getPostId(),'duplicate'=> '0']);
        }else{
            return $resultRedirect->setPath('*/*/');
        }


    }
}
