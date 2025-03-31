<?php
class Core_Block_Layout extends Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'page\root.phtml';
        $this->prepareChild();
        $this->prapareJsCss();
    }
    public function prepareChild()
    {
        $header = $this->createBlock('page/header');
        $this->addChild('header', $header);
        $message = $this->createBlock('core/message');
        $this->addChild('message', $message);
        $content = $this->createBlock('page/content');
        $this->addChild('content', $content);
        $footer = $this->createBlock('page/footer');
        $this->addChild('footer', $footer);
        $head = $this->createBlock('page/head');
        $this->addChild('head', $head);
    }

    public function prapareJsCss()
    {
        $this->getChild('head')
            ->addJs('page/common.js')
            ->addCss('page/common.css');
    }
    public function createBlock($block)
    {
        return Mage::getBlock($block);
    }
}