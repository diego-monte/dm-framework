<?php
require_once("./Config/Constants.php");
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.1.0.0
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

        $this->log = new Logs\Log;

        $this->usuario = DATABASE['DATABASE']['usuario'];
        $this->senha = DATABASE['DATABASE']['senha'];
        $this->banco = DATABASE['DATABASE']['banco'];
        $this->porta = DATABASE['DATABASE']['porta'];
        $this->endereco = DATABASE['DATABASE']['endereco'];

        $this->dbh = new \mysqli($this->endereco
                , $this->usuario
                , $this->senha
                , $this->banco
                , $this->porta);

        if (mysqli_connect_errno()) {
            $this->log->write(array("MSG"=> "The connection failed!", "CLASS" => __CLASS__)); 
            die(mysqli_connect_errno());
        }
        mysqli_set_charset($this->dbh, "utf8");

        $this->sSQL = '';
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
                $this->log->write(array("MSG"=> "Recurso $vKey desconhecido", "CLASS" => __CLASS__));            
                die("Recurso $vKey desconhecido");
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
                $this->log->write(array("MSG"=> "ERROR DELETE", "CLASS" => __CLASS__, "QUERY" => $delete)); 
                die('ERROR DELETE');
            }
        } else {
            $this->clearsql();
            $this->log->write(array("MSG"=> "ERROR DELETE", "CLASS" => __CLASS__, "QUERY" => $delete)); 
            die('DELETE ERROR SYSTEM');
        }
    }

    private function auditoria($from, $where, $operacao) {
        return true;
    }

    public function update($dump = false) {
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
                $this->log->write(array("MSG"=> "ERROR UPDATE", "CLASS" => __CLASS__, "QUERY" => $update)); 
                die('UPDATE ERROR SISTEM');
            }
        } else {
            $this->clearsql();
            throw new InvalidArgumentException('{'
                    . TYPE_SYSTEM
                    . ', ' . ERROR_SYSTEM
                    . ', ' . ERROR_FUNCTION . __FUNCTION__ . '"}');
        }
    }

    public function insert($dump = false) {
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
                $this->log->write(array("MSG"=> mysqli_error($this->dbh), "CLASS" => __CLASS__)); 
                die(mysqli_error($this->dbh));
            }

            die('INSERT ERROR SYSTEM');
        }
        $this->clearsql();
        return mysqli_insert_id($this->dbh);
    }

    public function get($dump = false) {
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
            die('SELECT ERROR SYSTEM');
        }
        $this->clearsql();
        return true;
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