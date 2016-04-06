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
use Application\Model\Employeeappraisal;

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
        $select->columns(array('id','name','email', 'designation', 'eid','process','doj','period', 'complete'));
        $select->from(array('e' => 'employeeappraisal'))
               ->join(array('h' => 'hierarchy'), 'h.emp_id = e.id', array(), 'left');
               
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('h.mngr_id', $mngr_id);
        $select->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        return $resultSet;
    }
    
    public function getEmpById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;
    }
    
    public function save(Employeeappraisal $emp) {
        $data = array(
            'name'          => $emp->name,
            'email'         => $emp->email,
            'designation'   => $emp->designation,
            'eid'           => $emp->eid,
            'process'       => $emp->process,
            'doj'           => $emp->doj,
            'period'        => $emp->period,
            'complete'      => $emp->complete,
        );
        $emp_id = (int) $emp->id;
        if ($emp_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
            $data = array(
                'complete' => $emp->complete,
            );
            $this->tableGateway->update($data, array('id' => $emp_id));
            return $emp_id;
        }
    }
    
    public function updatePswd(Employeeappraisal $emp) {
        $data = array(
            'pswd' => $emp->pswd,
        );
        $emp_id = (int) $emp->id;
        $this->tableGateway->update($data, array('id' => $emp_id));
        return $emp_id;
    }
}
