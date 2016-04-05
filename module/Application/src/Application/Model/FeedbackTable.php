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
use Application\Model\Feedback;

class FeedbackTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($where = null) {
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->order('id ASC');
        });
        return $resultSet;
    }
    
    public function getFeedbackId($feedback_id = '', $emp_id = '') {
        $feedback_id = (int) $feedback_id;
        if($feedback_id != '')
            $rowset = $this->tableGateway->select(array('id' => $feedback_id));
        if($emp_id != '')
            $rowset = $this->tableGateway->select(array('emp_id' => $emp_id));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;
    }
    
    public function save(Feedback $fback) {
        $data = array(
            'emp_id'                    => $fback->emp_id,
            'major_resoponsbilties'     => $fback->major_resoponsbilties,
            'extra_mile'                => $fback->extra_mile,
            'notable_accomplishments'   => $fback->notable_accomplishments,
        );

        $fback_id = (int) $fback->id;
        if ($fback_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
            //only update comments for manager
            $data1 = array(
                'e_manager_comment' => $fback->e_manager_comment,
                'n_manager_comment' => $fback->n_manager_comment,
                'overall_fb'        => $fback->overall_fb,
            );
            $this->tableGateway->update($data1, array('emp_id' => $fback_id));
            return $fback_id;
        }
    }
}
