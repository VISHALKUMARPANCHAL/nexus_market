<?php
class Ticket_Model_Resource_Comment extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('ticket_comment', 'comment_id');
    }
}