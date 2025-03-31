<?php
class Admin_Block_Widget_Grid_Toolbar extends Admin_Block_Widget_Grid
{
    protected $_limit = 10;
    protected $_page = 1;
    protected $_collection;
    public function __construct()
    {
        $this->_template = "admin/widget/grid/toolbar.phtml";
    }
    public function prepareToolbar()
    {
        $page = $this->getRequest()->getQuery('page');
        $limit = $this->getRequest()->getQuery('limit');
        $this->_page = (is_numeric($page)) ? $page : 1;
        $this->_limit = (is_numeric($limit)) ? $limit : 10;
        $this->_collection = clone $this->getParent()->getCollection();
        $this->getParent()->getCollection()->limit($this->_limit, $this->_page);
    }
    function getTotalRecords()
    {
        return count($this->_collection->getData());
    }
    public function getLimit()
    {
        return $this->_limit;
    }
    public function getPage()
    {
        return $this->_page;
    }
}