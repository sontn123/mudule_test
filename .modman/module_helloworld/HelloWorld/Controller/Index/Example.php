<?php

namespace Ecommage\HelloWorld\Controller\Index;

class Example extends \Magento\Framework\App\Action\Action
{

    protected $title;

    public function execute()
    {
//        var_dump($this->setTitle('Welcome'));
        echo $this->setTitle('Welcome');
//        var_dump($this->getTitle());die;
        echo $this->getTitle();
    }

    public function setTitle($title)
    {
        return $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}