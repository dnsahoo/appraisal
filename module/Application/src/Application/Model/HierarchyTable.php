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
use Application\Model\Hierarchy;

class HierarchyTable {

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
    
    public function save(Hierarchy $h) {
        $data = array(
            'emp_id' => $h->emp_id,
            'mngr_id' => $h->mngr_id,
        );

        $h_id = (int) $h->id;
        if ($h_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
                $this->tableGateway->update($data, array('id' => $h_id));
		return $h_id;
        }
    }
}
