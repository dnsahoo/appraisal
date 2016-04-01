<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Feedback {

    public $id;
    public $emp_id;
    public $major_resoponsbilties;
    public $extra_mile;
    public $manager_lead_comment;
    public $notable_accomplishments;
    public $overall_fb;
    protected $inputFilter;

    // Add content to this method:\
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : 0;
        $this->emp_id = (isset($data['emp_id'])) ? $data['emp_id'] : null;
        $this->major_resoponsbilties = (isset($data['major_resoponsbilties'])) ? $data['major_resoponsbilties'] : null;
        $this->extra_mile = (isset($data['extra_mile'])) ? $data['extra_mile'] : null;
        $this->manager_lead_comment = (isset($data['manager_lead_comment'])) ? $data['manager_lead_comment'] : null;
        $this->notable_accomplishments = (isset($data['notable_accomplishments'])) ? $data['notable_accomplishments'] : null;
        $this->overall_fb = (isset($data['overall_fb'])) ? $data['overall_fb'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'user_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
