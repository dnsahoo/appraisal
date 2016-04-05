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
use Application\Model\Rating;

class RatingTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function getRating($rating_id) {
        $rating_id = (int) $rating_id;
        $rowset = $this->tableGateway->select(array('id' => $rating_id));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;
    }

    public function fetchAll($where = null) {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($where) {
            $select->where($where);
           
        });
        //$resultSet->buffer();
        return $resultSet;
    }
    public function save(Rating $rtng) {
        $data = array(
            'emp_id'        => $rtng->emp_id,
            'aprsl_id'      => $rtng->aprsl_id,
            'aprsl_rate_id' => $rtng->aprsl_rate_id,
            'key_pointers'    => $rtng->key_pointers,
        );
        $rtng_id = (int) $rtng->id;
        if ($rtng_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
            //only update comments for manager
            $data = array(
                'comment'  => $rtng->comment,
                'manager_ratting'  => $rtng->manager_ratting,
            );
            if ($this->getRating($rtng_id)) {
                $this->tableGateway->update($data, array('id' => $rtng_id));
		  return $rtng_id;
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
     * Fetch record from Appraisal and Rating table
     */
    public function getAppraisalRating($emp_id, $dbAdapter = NULL) {
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->columns(array('r_id' => 'id','aprsl_rate_id','comment', 'manager_ratting', 'key_pointers'));
        $select->from(array('r' => 'rating'))
               ->join(array('a' => 'appraisal'), 'a.id = r.aprsl_id', array('id','type'), \Zend\Db\Sql\Select::JOIN_INNER);
               
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('r.emp_id', $emp_id);
        $select->where($where);
        $select->order('a.id ASC');
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();
        return $resultSet;
    }
}
