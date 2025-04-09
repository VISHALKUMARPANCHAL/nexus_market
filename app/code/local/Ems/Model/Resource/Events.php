<?php
class Ems_Model_Resource_Events   extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('ems_events', 'event_id');
    }
}