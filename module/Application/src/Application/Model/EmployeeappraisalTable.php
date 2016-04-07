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
        $resultSet = $resultSet->current();
        return $resultSet;
    }
    
    public function getEmpListByManagerId($mngr_id, $dbAdapter = NULL, $role = 0) {
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
//        $select->columns(array('id','name','email', 'designation', 'eid','process','doj','period', 'complete'));
//        $select->from(array('e' => 'employeeappraisal'));
        
        $select->columns(array('id'));
        $select->from(array('e1' => 'employeeappraisal'))
               ->join(array('e2' => 'employeeappraisal'), 'e2.parent = e1.id', array('e2_id'=>'id'), \Zend\Db\Sql\Select::JOIN_LEFT)
               ->join(array('e3' => 'employeeappraisal'), 'e3.parent = e2.id', array('e3_id'=>'id'), \Zend\Db\Sql\Select::JOIN_LEFT);
               
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('e1.id', $mngr_id);
        //$where->notEqualTo('e1.complete', '0');
        $select->where($where);
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        $e2_id = array();
        $e3_id = array();
        foreach ($resultSet as $key => $value) {
           $e2_id[] = $value['e2_id']; 
           $e3_id[] = $value['e3_id']; 
        }
        $final_ary = array_filter(array_unique(array_merge($e2_id, $e3_id)));
        $rs = array();
        foreach ($final_ary as $key => $emp_id){
            $rs[] = $this->getEmpById($emp_id);
        }
        return $rs;
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
            'change_pswd' => $emp->change_pswd,
        );
        $emp_id = (int) $emp->id;
        $this->tableGateway->update($data, array('id' => $emp_id));
        return $emp_id;
    }
    public function updateEmpAprsl($data = array(), $emp_id) {
        $this->tableGateway->update($data, array('id' => $emp_id));
        return $emp_id;
    }
}
