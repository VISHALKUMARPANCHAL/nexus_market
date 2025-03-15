<?php
class Cms_Controller_index extends Core_Controller_Front_Action
{
    public function __construct() {}
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $slider = $layout->createBlock('cms/index')
            ->setTemplate('cms/slider.phtml');
        $layout->getChild('content')->addChild('slider', $slider);
        $layout->getChild('head')
            ->addCss('page/cms/slider.css')
            ->addJs('page/cms/slider.js');
        $layout->toHtml();
    }
}