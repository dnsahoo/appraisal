<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Between;
use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Predicate\Like;

use Application\Model\Rating;

class EmployeeappraisalTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($where = null) {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($where) {
            $select->where($where);
        });
        $resultSet->buffer();
        return $resultSet;
    }
    
    public function getEmpListByManagerId($mngr_id, $dbAdapter = NULL) {
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->columns(array('id','name','email','eid','process','doj','period', 'complete'));
        $select->from(array('e' => 'employeeappraisal'))
               ->join(array('h' => 'hierarchy'), 'h.emp_id = e.id', array(), 'left');
               
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('h.mngr_id', $mngr_id);
        $select->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        return $resultSet;
    }
}
