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
    protected function _getDbColumns()
    {
        $sql = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = N'{$this->_tableName}'";
        // echo $sql;
        return $this->getAdapter()->fetchCol($sql, 'COLUMN_NAME');
        // echo '<pre>';
        // print_r($column_name);
        // echo '</pre>';
    }
    public function save($model)
    {
        $dbcolumn = $this->_getDbColumns();
        // echo '<pre>';
        // print_r($dbcolumn);
        // echo '</pre>';
        // die;
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
        // print_r($model);
        // print_r($primaryId);
        // echo '</pre>';
        // die;
        if ($primaryId) {
            $columns = [];
            unset($data[$primarykey]);
            foreach ($data as $key => $value) {
                if (in_array($key, $dbcolumn)) {
                    $value = ($value !== null) ? $value : '';
                    $columns[] = sprintf("`%s` = '%s'", $key, addslashes($value));
                }
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
            $columns = [];
            $values = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $dbcolumn)) {
                    $values[] =  $value;
                    $columns[] = $key;
                }
            }

            $columns = implode('`,`', $columns);
            $values = implode("','", $values);
            $sql = sprintf("INSERT INTO %s(`%s`) VALUES ('%s')", $this->_tableName, $columns, $values);
            echo $sql;
            $id = $this->getAdapter()->insert($sql);

            $model->{$this->_primaryKey} = $id;
        }
    }
    public function delete($model)
    {
        $data = $model->getData();
        $primaryId = 0;
        if (isset($data[$this->_primaryKey]) && $data[$this->_primaryKey]) {
            $primaryId = $data[$this->_primaryKey];
        }
        $sql = sprintf(
            "DELETE FROM %s WHERE %s = %d",
            $this->_tableName,
            $this->_primaryKey,
            $primaryId
        );
        if ($this->getAdapter()->query($sql)) {
            $model->setData(null);
        }
    }
}
