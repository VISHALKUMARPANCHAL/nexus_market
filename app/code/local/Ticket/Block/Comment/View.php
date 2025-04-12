<?php
class Reply_Block_Comment_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('reply/comment/view.phtml');
    }
}