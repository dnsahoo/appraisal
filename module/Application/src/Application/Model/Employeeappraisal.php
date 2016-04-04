<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Employeeappraisal {

    public $id;
    public $name;
    public $email;
    public $eid;
    public $process;
    public $doj;
    public $period;
    public $complete;
    protected $inputFilter;

    // Add content to this method:\
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->eid = (isset($data['eid'])) ? $data['eid'] : null;
        $this->process = (isset($data['process'])) ? $data['process'] : null;
        $this->doj = (isset($data['doj'])) ? $data['doj'] : null;
        $this->period = (isset($data['period'])) ? $data['period'] : null;
        $this->complete = (isset($data['complete'])) ? $data['complete'] : '0'; //0 for not completed
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
