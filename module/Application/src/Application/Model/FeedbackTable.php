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
    
    public function getFeedbackId($feedback_id) {
        $feedback_id = (int) $feedback_id;
        $rowset = $this->tableGateway->select(array('id' => $feedback_id));
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
            'manager_lead_comment'      => $fback->manager_lead_comment,
            'notable_accomplishments'   => $fback->notable_accomplishments,
            'overall_fb'                => $fback->overall_fb,
        );

        $fback_id = (int) $fback->id;
        if ($fback_id == 0) {
            $this->tableGateway->insert($data);
            return $lastId = $this->tableGateway->getLastInsertValue();
        } else {
            //only update comments for manager
            $data = array(
                'manager_lead_comment' => $fback->manager_lead_comment,
                'overall_fb'           => $fback->overall_fb,
            );
            if ($this->getFeedbackId($fback_id)) {
                $this->tableGateway->update($data, array('id' => $fback_id));
		  return $fback_id;
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
}
