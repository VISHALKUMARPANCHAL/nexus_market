<?php
class Ticket_Model_Resource_Ticket extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('ticket', 'ticket_id');
    }
}
