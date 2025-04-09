<?php
class Ems_Model_Resource_Registrations   extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('ems_registrations', 'registration_id');
    }
}