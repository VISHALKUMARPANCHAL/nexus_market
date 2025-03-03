<?php
class Core_Model_Resource_Abstract
{

    protected $_tableName;
    protected $_primaryKey;
    public function __construct()
    {
        $this->_construct();
    }
    public function init($tableName, $primaryKey)
    {
        $this->_tableName = $tableName;
        $this->_primaryKey = $primaryKey;
    }
    public function getTableName()
    {
        return  $this->_tableName;
    }
    protected function _construct()
    {
        return $this;
    }
    public function getAdapter()
    {
        return new Core_Model_DB_Adapter();
    }
    public function load($value, $field = null)
    {
        $field = (is_null($field)) ? $this->_primaryKey : $field;
        $sql = "SELECT * FROM {$this->_tableName} WHERE {$field}='{$value}' LIMIT 1";
        // echo $sql;
        // die;
        return $this->getAdapter()->fetchRow($sql);
        // echo "<pre>";
        // print_r($data);
    }
    public function save($model)
    {
        $data = $model->getData();
        $primaryId = 0;
        $primarykey =  $this->_primaryKey;

        // echo '<pre>';
        // print_r($primarykey);
        // echo '</pre>';
        if (isset($data[$primarykey]) &&  $data[$primarykey]) {
            $primaryId = $data[$primarykey];
        }
        // echo '<pre>';
        // print_r($primaryId);
        // echo '</pre>';
        // die;
        if ($primaryId) {

            $columns = [];
            unset($data[$primarykey]);
            foreach ($data as $key => $value) {
                $value = ($value !== null) ? $value : '';
                $columns[] = sprintf("`%s` = '%s'", $key, addslashes($value));
            }
            $sql = sprintf(
                "UPDATE %s SET %s WHERE %s = %d",
                $this->_tableName,
                implode(',', $columns),
                $primarykey,
                $primaryId
            );
            // echo $sql;
            // die;
            return $this->getAdapter()->query($sql);
        } else {
            $columns = implode('`,`', array_keys($data));
            $values = implode("','", array_values($data));
            $sql = sprintf("INSERT INTO %s(`%s`) VALUES ('%s')", $this->_tableName, $columns, $values);
            // echo $sql;
            // die;
            $id = $this->getAdapter()->insert($sql);

            $model->load($id);
            // echo $id;
            // echo '<pre>';
            // print_r($model);
            // echo '</pre>';

            // echo "Insert";
        }
        // echo get_class($model);
    }
    public function delete($model)
    {
        $id = $model->getData();
        echo '<pre>';
        print_r($id);
        echo '</pre>';
        if (isset($id)) {
            $sql = sprintf("DELETE FROM %s WHERE %s = %s", $this->_tableName, $this->_primaryKey, $id);
            // echo $sql;
            // die;
            $this->getAdapter()->query($sql);
            $model->setData(null);
        }
    }
}