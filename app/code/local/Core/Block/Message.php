<?php
class Core_Block_Message extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("page/message.phtml");
    }
    public function getMessage()
    {
        return $this->getRequest()->getMessageModel()->getMessage();
    }
    public function getError()
    {
        return $this->getRequest()->getMessageModel()->getError();
    }
    public function getSuccess()
    {
        return $this->getRequest()->getMessageModel()->getSuccess();
    }
    public function getWarning()
    {
        return $this->getRequest()->getMessageModel()->getWarning();
    }
}
