<?php
class Core_Model_Resource_Collection_Abstract
{
    protected $_resource;
    protected $_model;
    protected $_select = [];
    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }
    public function setModel($model)
    {
        $this->_model = $model;
        return $this;
    }
    public function select($columns = ["*"])
    {
        $this->_select['FROM'] = ["main_table" => $this->_resource->getTableName()];
        $this->_select['COLUMNS'] = [];
        $columns = is_array($columns) ? $columns : [$columns];
        foreach ($columns as $aleas => $column) {
            // Mage::log($aleas);
            // Mage::log($column);
            if (is_integer($aleas)) {
                $this->_select['COLUMNS'][] = "main_table." . $column;
            } else {
                $this->_select['COLUMNS'][] = sprintf("%s AS %s", $aleas, $column);
            }
        }
        return $this;
    }


    public function getData()
    {
        $data = $this->_resource->getAdapter()->fetchAll($this->prepareQuery());
        foreach ($data as &$_data) {
            $model = new $this->_model;
            $_data = $model->setData($_data);
        }
        return $data;
    }
    public function addFieldToFilter($field, $condition)
    {
        if (!is_array($condition)) {
            $condition = ['eq' => $condition];
        }
        $this->_select['WHERE'][$field][] = $condition;
        return $this;
    }
    public function prepareQuery()
    {

        $query = sprintf("SELECT %s FROM %s AS %s", implode(', ', $this->_select['COLUMNS']), array_values($this->_select['FROM'])[0], array_keys($this->_select['FROM'])[0]);

        if (isset($this->_select['LEFT_JOIN'])) {
            $leftjoinsql = "";
            foreach ($this->_select["LEFT_JOIN"] as $leftjoin) {
                $leftjoinsql .= sprintf(
                    " LEFT JOIN %s AS %s ON %s ",
                    array_values($leftjoin['tablename'])[0],
                    array_keys($leftjoin['tablename'])[0],
                    $leftjoin['condition']
                );
            }
            $query .= " " . $leftjoinsql;
        }
        if (isset($this->_select['RIGHT_JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['RIGHT_JOIN'] as $rightJoin) {
                $joinsql .= sprintf(" RIGHT JOIN  %s ON %s ", $rightJoin['tableName'], $rightJoin['condition']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['INNER_JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['INNER_JOIN'] as $innerJoin) {
                $joinsql .= sprintf(" INNER JOIN  %s ON %s ", $innerJoin['tableName'], $innerJoin['condition']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['JOIN'] as $join) {
                $joinsql .= sprintf("JOIN  %s ON %s ", $join['tableName'], $join['condition']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['FULL_JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['FULL_JOIN'] as $fullJoin) {
                $joinsql .= sprintf("FULL JOIN  %s ", $fullJoin['tableName']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['CROSS_JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['CROSS_JOIN'] as $crossJoin) {
                $joinsql .= sprintf("CROSS JOIN  %s ", $crossJoin['tableName']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['SELF_JOIN'])) {
            $joinsql = sprintf(" %s, %s %s", $this->_select['SELF_JOIN'][0]['tableAleas'][0], $this->_select['FROM'], $this->_select['SELF_JOIN'][0]['tableAleas'][1]);
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['NATURAL_JOIN'])) {
            $joinsql = "";
            foreach ($this->_select['NATURAL_JOIN'] as $crossJoin) {
                $joinsql .= sprintf("NATURAL JOIN  %s ", $crossJoin['tableName']);
            }
            $query = $query . " " . $joinsql;
        }
        if (isset($this->_select['WHERE'])) {
            $wheresql = "";
            $count = count($this->_select['WHERE']);
            $conditions = [];
            foreach ($this->_select['WHERE'] as $field => $value) {
                foreach ($value as $_value) {
                    $conditions[] = $this->preparewhere($field, $_value);
                }
            }

            $wheresql .= "WHERE " . implode(' AND ', $conditions);
            $query = $query . " " . $wheresql;
        }
        if (isset($this->_select['GROUP_BY'])) {
            $groupsql = sprintf("GROUP BY %s", implode(',', $this->_select['GROUP_BY']['columns']));
            $query = $query . " " . $groupsql;
        }
        if (isset($this->_select['HAVING']) && isset($this->_select['GROUP_BY'])) {
            $conditions = [];
            // echo '<pre>';
            // print_r($this);
            // echo '</pre>';
            foreach ($this->_select['HAVING'] as $field => $value) {
                foreach ($value as $_value) {
                    $conditions[] = $this->preparewhere($field, $_value);
                }
            }
            // echo '<pre>';
            // print_r($conditions);
            // echo '</pre>';
            $groupsql = sprintf("HAVING %s", implode(',', $conditions));
            $query = $query . " " . $groupsql;
        }
        if (isset($this->_select['ORDERBY'])) {
            $ordersql = "ORDER BY ";
            // foreach ($this->_select['ORDERBY'] as $values) {
            //     $groupsql .= $values['column'] . ' ';
            //     if ($values['order'] != 0) {
            //         $groupsql .=  $values['order'] . ',';
            //     }
            //     if (count()) {
            //     }
            // }

            $ordersql .= implode(', ', $this->_select['ORDERBY']['column']);
            $query = $query . " " . $ordersql;
        }
        if (isset($this->_select['LIMIT'])) {
            $ordersql = sprintf("LIMIT %s", $this->_select['LIMIT']['limit']);
            if ($this->_select['LIMIT']['offset'] != '') {
                $ordersql .= " OFFSET " . $this->_select['LIMIT']['offset'];
            }
            $query = $query . " " . $ordersql;
        }
        // echo $query;
        // die;
        return $query;
    }

    public function preparewhere($field, $value)
    {

        $where = "";
        if (is_array($value)) {

            foreach ($value as $operator => $_value) {
                switch (strtoupper($operator)) {
                    case 'IN':
                    case 'NOT IN':

                        $_value = (is_array($_value)) ? $_value : [$_value];

                        foreach ($_value as $key => $val) {

                            $inarryvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                        }
                        $_value = implode(',', $inarryvalues);
                        $where  = " {$field} {$operator} ({$_value}) ";
                        // echo '<pre>';
                        // print_r($where);
                        // echo '</pre>';
                        break;

                    case 'BETWEEN':
                    case 'NOT BETWEEN':
                        foreach ($value as $key => $val) {
                            if (is_array($val)) {
                                foreach ($val as $limits) {
                                    $betweenvalues[] = (is_string($limits)) ? "'{$limits}'" : "{$limits}";
                                }
                            } else {
                                $betweenvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                            }
                        }
                        $betweenvaluestring = implode(' AND ', $betweenvalues);
                        $where  =   " {$field} {$operator} {$betweenvaluestring}";
                        break;
                    case 'EQ':
                        $where = "{$field} = '{$_value}'";
                        break;

                    default:
                        $where = " {$field} {$operator} '{$_value}' ";
                        break;
                }
            }
        }
        // print_r($where);
        return $where;
    }

    public function leftJoin($tableName, $condition, $columns)
    {
        $this->_select["LEFT_JOIN"][] = [
            "tablename" => $tableName,
            "condition" => $condition,
            "columns" => $columns
        ];
        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf(
                "%s.%s AS %s",
                array_keys($tableName)[0],
                $columnname,
                $alias
            );
        }
        return $this;
    }
    public function rightJoin($tableName, $condition, $columns)
    {
        $this->_select["RIGHT_JOIN"][] = [
            'tableName' => $tableName,
            'condition' =>  $condition,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }

        return $this;
    }
    public function innerJoin($tableName, $condition, $columns)
    {
        $this->_select["INNER_JOIN"][] = [
            'tableName' => $tableName,
            'condition' =>  $condition,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }

        return $this;
    }
    public function join($tableName, $condition, $columns)
    {
        $this->_select["JOIN"][] = [
            'tableName' => $tableName,
            'condition' =>  $condition,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }
        return $this;
    }
    public function fullJoin($tableName, $columns)
    {
        $this->_select["FULL_JOIN"][] = [
            'tableName' => $tableName,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }
        return $this;
    }
    public function crossJoin($tableName, $columns)
    {
        $this->_select["CROSS_JOIN"][] = [
            'tableName' => $tableName,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }
        return $this;
    }
    public function selfJoin($tableAleas, $columns)
    {
        $this->_select["SELF_JOIN"][] = [
            'tableAleas' => $tableAleas,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s AS %s", $columnName, $aleas);
        }
        return $this;
    }
    public function naturalJoin($tableName, $columns)
    {
        $this->_select["NATURAL_JOIN"][] = [
            'tableName' => $tableName,
            'columns' => $columns
        ];
        foreach ($columns as $aleas => $columnName) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnName, $aleas);
        }
        return $this;
    }
    public function groupBy($columns)
    {
        $this->_select["GROUP_BY"] = [
            'columns' => $columns
        ];
        return $this;
    }
    public function having($column, $conditions)
    {
        if (!is_array($conditions)) {
            $conditions = ['eq' => $conditions];
        }
        $this->_select["HAVING"][$column] = [
            'condition' => $conditions
        ];
        return $this;
    }
    public function orderBy($columns)
    {
        $this->_select["ORDERBY"] = [
            'column' => $columns
        ];
        return $this;
    }
    public function limit($limit, $offset = "")
    {
        $this->_select["LIMIT"] = [
            'limit' => $limit,
            'offset' => $offset
        ];
        return $this;
    }
    private function _getTableAleas($table)
    {
        return array_keys($table)[0];
    }
    private function _getTableName($table)
    {
        return array_values($table)[0];
    }
    public function getFirstItem()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return $this->_model;
        }
    }
}
