<?php
require_once("./Config/Constants.php");
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
use Core\Logs as Logs;

class ModelsClass {

    private $mysqlComands = array("now()","NULL");
    private $dbh;
    private $sSQL;
    private $result;
    private $usuario;
    private $senha;
    private $banco;
    private $porta;
    private $endereco;
    private $from;
    private $where;
    private $select;
    private $set;
    private $order;
    private $group;
    private $limit;
    private $join;
    private $transaction = false;
    private $data;
    private $log;
    private $teste;

    public function __construct() {
        try {
            $this->log = new Logs\Log;

            $this->usuario = DATABASE['DATABASE']['usuario'];
            $this->senha = DATABASE['DATABASE']['senha'];
            $this->banco = DATABASE['DATABASE']['banco'];
            $this->porta = (int)DATABASE['DATABASE']['porta'];
            $this->endereco = DATABASE['DATABASE']['endereco'];

            $this->dbh = new \mysqli($this->endereco
                    , $this->usuario
                    , $this->senha
                    , $this->banco
                    , $this->porta);

            if (mysqli_connect_errno()) {
                throw new \InvalidArgumentException("The connection failed!");
            }
            mysqli_set_charset($this->dbh, "utf8");

            $this->sSQL = '';

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(),
                "ERROR" => mysqli_connect_error(), 
                "CLASS" => __CLASS__
            ));
        }
    }

    public function __destruct() {

        if ($this->result != null) {
            $this->result->close();
        }

        if ($this->dbh != null) {
            $this->dbh->close();
        }
    }

    public function start_transaction() {
        mysqli_begin_transaction($this->dbh, MYSQLI_TRANS_START_READ_WRITE);
        $this->transaction = true;
    }

    public function commit() {
        mysqli_commit($this->dbh);
        $this->transaction = false;
    }

    public function rollback() {
        mysqli_rollback($this->dbh);
        $this->transaction = false;
    }

    public function select($obj) {
        if (is_array($obj)) {
            foreach ($obj as $val) {
                $this->select[] = $val;
            }
        } else {
            $this->select[] = $obj;
        }
    }

    public function set($array) {
        foreach ($array as $key => $val) {
            if (in_array(trim($val), $this->mysqlComands)) {
                $this->set[] = $key . " = " . $val;
            } else {
                if (gettype($val) == 'string') {
                    $this->set[] = $key . " = '" . $this->escape($val) . "'";
                } else if (is_bool($val)) {
                    if ($val) {
                        $this->set[] = $key . " = true";
                    } else {
                        $this->set[] = $key . " = false";
                    }
                } else if (is_null($val)) {
                    $this->set[] = $key . " = NULL";
                } else {
                    $this->set[] = $key . " = " . $this->escape($val);
                }
            }
        }
    }

    public function escape($string) {
        return mysqli_escape_string($this->dbh, $string);
    }

    public function from($string) {
        $this->from = $string;
    }

    public function join($table, $on, $left = false) {
        if ($left) {
            $this->join[] = "LEFT JOIN " . $table . " ON " . $on;
        } else {
            $this->join[] = "INNER JOIN " . $table . " ON " . $on;
        }
    }

    private function make_custom_where($key,$val){
        try {
            $vKey = array_keys($val)[0];
            switch($vKey){
                case 'eq':
                    return $key . " = '" . $this->escape($val[$vKey]) .  "'";
                case 'lk':
                    return $key . " like '%" . $this->escape($val[$vKey]) .  "%'";
                case 'lks':
                    return $key . " like '" . $this->escape($val[$vKey]) .  "%'";
                case 'lke':
                    return $key . " like '%" . $this->escape($val[$vKey]) .  "'";
                case 'gt':
                    return $key . " > '" . $this->escape($val[$vKey]) . "'";
                case 'gte':
                    return $key . " >= '" . $this->escape($val[$vKey]) . "'";
                case 'lt':
                    return $key . " < '" . $this->escape($val[$vKey]) . "'";
                case 'lte':
                    return $key . " <= '" . $this->escape($val[$vKey]) . "'";
                default :  
                    throw new \InvalidArgumentException(array("MSG"=> "Unknown $vKey resource", "CLASS" => __CLASS__));  
            }

        } catch (\Exception $e) {
            $this->log->write($e->getMessage());
        }
    }
    
    public function where($obj) {
        if (is_array($obj)) {
            foreach ($obj as $key => $val) {
                if(is_array($val)){
                    $this->where[] = $this->make_custom_where($key,$val);
                }else if (in_array(trim($val), $this->mysqlComands)) {                
                    $this->where[] = $key . " = " . $val;
                } else {
                    if (substr($key, -2) == '!=') {
                        $this->where[] = $key . " '" . $this->escape($val) . "'";
                    } else {
                        $this->where[] = $key . " = '" . $this->escape($val) . "'";
                    }
                }
            }
        } else {
            $this->where[] = $obj;
        }
    }

    public function limit($offset, $limit) {
        $this->limit = $offset . ',' . $limit;
    }

    public function orderby($obj) {
        if (is_array($obj)) {
            foreach ($obj as $key => $val) {
                $this->order[$key] = $val;
            }
        } else {
            $this->order[] = $obj;
        }
    }

    public function groupby($obj) {
        if (is_array($obj)) {
            foreach ($obj as $val) {
                $this->group[] = $val;
            }
        } else {
            $this->group[] = $obj;
        }
    }

    public function clearsql() {
        unset($this->from);
        unset($this->where);
        unset($this->select);
        unset($this->set);
        unset($this->order);
        unset($this->order);
        unset($this->group);
        unset($this->limit);
        unset($this->join);
    }

    public function delete($dump = false) {
        try {
            $i = 0;
            $sWhere = '';
            if (!empty($this->where)) {
                foreach ($this->where as $val) {
                    if ($i != 0) {
                        $sWhere .= ' and ';
                    }
                    $sWhere .= $val;
                    $i++;
                }
                $sWhere = " where " . $sWhere;
            }

            $delete = "delete from " . $this->from . ' ' . $sWhere;
            
            if ($dump){
                die($delete);
            }

            if ($this->auditoria($this->from, $sWhere, 'delete')) {
                if (mysqli_query($this->dbh, $delete)) {
                    $rows_affected = $this->getaffectedrows();

                    $this->clearsql();
                    return $rows_affected;
                } else {
                    $this->clearsql();
                    if ($this->transaction){
                        $this->rollback();
                    }
                    throw new \InvalidArgumentException(array("MSG"=> "Delete error system", "QUERY" => $delete, "CLASS" => __CLASS__)); 
                }
            } else {
                $this->clearsql();
                throw new \InvalidArgumentException("Delete error system");
            }

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(),
                "QUERY" => $delete, 
                "CLASS" => __CLASS__
            ));
        }
    }

    private function auditoria($from, $where, $operacao) {
        return true;
    }

    public function update($dump = false) {
        try {
            $i = 0;
            $sWhere = '';
            if (!empty($this->where)) {
                foreach ($this->where as $val) {
                    if ($i != 0) {
                        $sWhere .= ' and ';
                    }
                    $sWhere .= $val;
                    $i++;
                }
                $sWhere = " where " . $sWhere;
            }
            $set = '';
            foreach ($this->set as $val) {
                $set .= $val . ',';
            }

            $set = substr($set, 0, -1);

            $update = "update " . $this->from . " set " . $set . " " . $sWhere;

            if ($dump){
                die($update);
            }

            if ($this->auditoria($this->from, $sWhere, 'update')) {
                if (mysqli_query($this->dbh, $update)) {
                    $this->clearsql();
                    return true;
                } else {
                    $this->clearsql();
                    
                    if ($this->transaction){
                        $this->rollback();
                    }
                    throw new \InvalidArgumentException("Update error system");
                }
            } else {
                $this->clearsql();
                throw new \InvalidArgumentException("Update error system");
            }

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(),
                "QUERY" => $update, 
                "CLASS" => __CLASS__
            ));
        }
    }

    public function insert($dump = false) {
        try {
            $set = '';
            foreach ($this->set as $val) {
                $set .= $val . ',';
            }

            $set = substr($set, 0, -1);

            $insert = "insert into " . $this->from . " set " . $set;

            if ($dump){
                die($insert);
            }

            $query = mysqli_query($this->dbh, $insert);
            if ($query === false) {
                $this->clearsql();
                if ($this->transaction) {
                    $this->rollback();
                }

                if (mysqli_errno($this->dbh) == 1406) {
                    throw new \InvalidArgumentException(mysqli_error($this->dbh));
                }

                throw new \InvalidArgumentException("Insert error system");
            }
            $this->clearsql();
            return mysqli_insert_id($this->dbh);

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(),
                "QUERY" => $insert, 
                "CLASS" => __CLASS__
            ));
        }
    }

    public function get($dump = false) {
        try {
            $i = 0;
            $sWhere = '';
            if (!empty($this->where)) {
                foreach ($this->where as $val) {
                    if ($i != 0) {
                        $sWhere .= ' and ';
                    }
                    $sWhere .= $val;
                    $i++;
                }
                $sWhere = " where " . $sWhere;
            }

            $i = 0;
            $sOrderBy = '';
            if (!empty($this->order)) {
                foreach ($this->order as $key => $val) {
                    if ($i != 0) {
                        $sOrderBy .= ', ';
                    }

                    if(is_numeric($key)){
                        $sOrderBy .= $val;                
                    }else{
                        $sOrderBy .= $key . ' ' . $val;
                    }
                    $i++;
                }
                $sOrderBy = " order by " . $sOrderBy;
            }


            $i = 0;
            $sGroupBy = '';
            if (!empty($this->group)) {
                foreach ($this->group as $val) {
                    if ($i != 0) {
                        $sGroupBy .= ', ';
                    }
                    $sGroupBy .= $val;
                    $i++;
                }
                $sGroupBy = " group by " . $sGroupBy;
            }

            $field = '';
            if (!empty($this->select) && count($this->select) > 0) {
                foreach ($this->select as $val) {
                    $field .= $val . ',';
                }
            } else {
                $field = '* ';
            }

            $join = '';

            if (!empty($this->join)) {
                foreach ($this->join as $val) {
                    $join .= $val . ' ';
                }
            }

            $field = substr($field, 0, -1);

            $select = "select " . $field
                    . " from " . $this->from . " "
                    . $join . " "
                    . $sWhere . " "
                    . $sGroupBy . " "
                    . $sOrderBy; 

            if (!empty($this->limit)) {
                $select .= " LIMIT " . $this->limit;
            }

            if ($dump) {
                die($select);
            }

            $this->result = mysqli_query($this->dbh, $select);

            if ($this->result === false) {
                $this->clearsql();
                throw new \InvalidArgumentException("Select error system");
            }
            $this->clearsql();
            return true;

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(),
                "QUERY" => $select, 
                "CLASS" => __CLASS__
            ));
        }
    }

    public function getresult() {
        return $this->result;
    }

    public function getrowcount() {
        return mysqli_num_rows($this->result);
    }

    public function getaffectedrows() {
        return mysqli_affected_rows($this->dbh);
    }

    public function result() {
        return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
    }

    public function result_object() {
        return mysqli_fetch_object($this->result);
    }

    public function error() {
        return mysqli_error($this->dbh);
    }

    public function last_insert_id() {
        return mysqli_insert_id($this->dbh);
    }

    public function freesql() {
        mysqli_free_result($this->result);
        $this->result = null;
    }

}