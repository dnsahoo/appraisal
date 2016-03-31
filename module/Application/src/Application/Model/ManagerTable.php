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
use Application\Model\Manager;

class ManagerTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function getManager($manager_id) {
        $manager_id = (int) $manager_id;
        $rowset = $this->tableGateway->select(array('id' => $manager_id));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;
    }

    public function fetchAll($where = null) {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($where) {
            $select->where($where);
            $select->order('email');
        });
        $resultSet->buffer();
        return $resultSet;
    }
    public function save(Manager $mngr) {
        $data = array(
            'email' => $mngr->email,
            'pwd'  => sha1($mngr->pwd),
        );

        $mngr_id = (int) $mngr->id;
        if ($mngr_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getManager($mngr_id)) {
                $this->tableGateway->update($data, array('id' => $mngr_id));
		  return $mngr_id;
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    public function getManagerByEmail($email,$mngr_id='') {
        $where = new Where();
        $where->equalTo('email', $email);
		
        if(!empty($mngr_id))
            $where->notEqualTo('id', $mngr_id);
        $rowset = $this->tableGateway->select($where);
        $row = $rowset->current();
        if (!empty($row)) {
            return $row;
        }
        return NULL;
    }
    
        public function fetchManagerExceptLoginUsr($loginUsr = '') {
        $where = new Where();
        if(!empty($loginUsr))
            $where->notEqualTo('email', $loginUsr);
        $resultSet = $this->tableGateway->select(function (Select $select) use ($where) {
            $select->where($where);
            $select->order('email ASC');
        });
        $resultSet->buffer();
        return $resultSet;
    }	
}
