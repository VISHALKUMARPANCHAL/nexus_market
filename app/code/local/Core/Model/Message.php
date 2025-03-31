<?php
class Core_Model_Message extends Core_Model_Session
{
    function addMessage($type, $message)
    {
        $getType = sprintf("add%s", ucfirst($type));
        if (empty($this->get('message'))) {
            $this->set('message',  []);
        }
        $this->$getType($message);
    }
    function getMessage()
    {
        if (!empty($this->get('message'))) {
            return $this->get('message');
        } else {
            return [];
        }
    }
    function addError($message)
    {
        $messages = $this->get('message') ?: [];
        $messages['error'][] = $message;
        $this->set('message', $messages);
        return $this;
    }
    function getError()
    {
        $messages = $this->get('message');
        $error = isset($messages['error']) ? $messages['error'] : [];
        unset($messages['error']);
        $this->set('message', $messages);
        return $error;
    }
    function addSuccess($message)
    {
        $messages = $this->get('message') ?: [];
        $messages['success'][] = $message;
        $this->set('message', $messages);
        return $this;
    }
    function getSuccess()
    {
        $messages = $this->get('message');
        $success = isset($messages['success']) ? $messages['success'] : [];
        unset($messages['success']);
        $this->set('message', $messages);
        return $success;
    }
    function addWarning($message)
    {
        $messages = $this->get('message') ?: [];
        $messages['warning'][] = $message;
        $this->set('message', $messages);
        return $this;
    }
    function getWarning()
    {
        $messages = $this->get('message');
        $warning = isset($messages['warning']) ? $messages['warning'] : [];
        unset($messages['warning']);
        $this->set('message', $messages);
        return $warning;
    }
}