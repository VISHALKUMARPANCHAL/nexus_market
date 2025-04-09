<?php
class Core_Model_Request
{
    protected $_moduleName = "";
    protected $_controllerName = "";
    protected $_actionName = "";
    protected $_baseUrl = "http://localhost/ecommerceweb/";
    protected $_baseDir = 'C:/xampp/htdocs/ecommerceweb';
    public function __construct()
    {
        $uri = $this->getRequestUri();
        $uri = array_filter(explode("/", $uri));
        $this->_moduleName = isset($uri[0]) ? $uri[0] : 'cms';
        $this->_controllerName = isset($uri[1]) ? $uri[1] : 'index';
        $this->_actionName = isset($uri[2]) ? explode('?', $uri[2])[0] : 'index';
        // return $this;
    }
    public function getRequestUri()
    {
        $stringUrl = $_SERVER['REQUEST_URI'];
        $stringUrl = str_replace('/ecommerceweb/', '', $stringUrl);
        return $stringUrl;
    }
    public function getMessageModel()
    {
        return Mage::getSingleton('core/message');
    }
    public function getModuleName()
    {
        return $this->_moduleName;
    }
    public function getControllerName()
    {
        return $this->_controllerName;
    }
    public function getActionName()
    {
        return $this->_actionName;
    }
    public static function getParam($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        } else {
            return '';
        }
    }
    public static function getParams()
    {
        return $_POST;
    }

    public static function getQuery($field = null)
    {
        if ($field === null) {
            return $_GET;
        }
        if (isset($_GET[$field])) {
            return $_GET[$field];
        } else {
            return "";
        }
    }
    public function isAgexRequest()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
