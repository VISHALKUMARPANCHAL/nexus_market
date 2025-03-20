<?php
class Core_Block_Layout_Admin extends Core_Block_Layout
{
    public function __construct()
    {
        $this->_template = 'page\root.phtml';
        $this->prepareChild();
        $this->prapareJsCss();
    }
    public function prepareChild()
    {
        $header = $this->createBlock('page/header')->setTemplate('page/admin/header.phtml');
        $this->addChild('header', $header);
        $head = $this->createBlock('page/head')->setTemplate('page/admin/head.phtml');
        $this->addChild('head', $head);
        $content = $this->createBlock('page/content')->setTemplate('page/admin/content.phtml');
        $this->addChild('content', $content);
        $footer = $this->createBlock('page/footer')->setTemplate('page/admin/footer.phtml');
        $this->addChild('footer', $footer);
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