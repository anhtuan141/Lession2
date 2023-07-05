<?php
class QueryBuilder extends Database
{
    protected $table;

    public function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
    }

    // TODO: fix convention
    public function insert($data = [])
    {
        $strColumn = $quest = '';
        $params = [];
        foreach ($data as $column => $value) {
            $strColumn .= "`$column`,";
            $quest .= '?,';
            $params[] = trim($value);
        }
        $strColumn = rtrim($strColumn, ',');
        $quest = rtrim($quest, ',');
        $sql = 'INSERT INTO `' . $this->table . '` 
        (' . $strColumn . ') 
        VALUES (' . $quest . ');';
        return $this->setquery($sql)->save($params);
    }

    public function update($data = [], $where = [])
    {
        $strSet = $strWhere = '';
        $params = [];
        foreach ($data as $column => $value) {
            $strSet .= "`$column` = ?,";
            $params[] = trim($value);
        }
        $strSet = rtrim($strSet, ',');

        if ($where) {
            foreach ($where as $column => $value) {
                $strWhere .= " and `$column` = ? ";
                $params[] = trim($value);
            }
        }

        $sql = 'UPDATE `' . $this->table . '` 
        SET ' . $strSet . ' 
        WHERE  1=1 ' . $strWhere;
        return $this->setquery($sql)->save($params);
    }

    public function delete($where = [])
    {
        $strWhere = '';
        $params = [];
        //build where đơn gian : where = và ket bằng and
        if ($where) {
            foreach ($where as $column => $value) {
                $strWhere .= " and `$column` = ? ";
                $params[] = trim($value);
            }
        }

        $sql = 'DELETE FROM `' . $this->table . '`  
        WHERE  1=1 ' . $strWhere;
        return $this->setquery($sql)->save($params);
    }

    public function select($where = [], $select = ['*'], $orderby = [])
    {
        $strWhere = $strSelect = $strOrderBy = '';
        $params = [];
        //build where đơn gian : where = và ket bằng and
        if ($where) {
            if (count($where) == 3) {
                $strWhere .= " and `" . $where[0] . "` " . $where[1] . " ? ";
                $params[] = trim($where[2]);
            } else {
                foreach ($where as $column => $value) {
                    $strWhere .= " and `$column` = ? ";
                    $params[] = trim($value);
                }
            }
        }
        $strSelect = implode(',', $select);
        //orderBy
        if ($orderby) {
            foreach ($orderby as $column => $sort) {
                $sort = strtoupper($sort);
                $strOrderBy .= " `$column`  $sort,";
            }
            $strOrderBy = rtrim($strOrderBy, ',');
            $strOrderBy = ' ORDER BY ' . $strOrderBy;
        }
        $sql = 'SELECT ' . $strSelect . '  
                FROM `' . $this->table . '`   
                WHERE  1=1 ' . $strWhere . $strOrderBy;
        return $this->setquery($sql)->rows($params);
    }

    public function item($where = [], $select = ['*'])
    {
        $strWhere = $strSelect = '';
        $params = [];
        if ($where) {
            foreach ($where as $column => $value) {
                $strWhere .= " and `$column` = ? ";
                $params[] = trim($value);
            }
        }
        $strSelect = implode(',', $select);
        //build where đơn gian : where = và ket bằng and       
        $sql = 'SELECT ' . $strSelect . '  
                FROM `' . $this->table . '`   
                WHERE  1=1 ' . $strWhere;
        return $this->setquery($sql)->row($params);
    }
}
