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
    public $designation;
    public $eid;
    public $process;
    public $doj;
    public $period;
    public $complete;
    public $pswd;
    public $change_pswd;
    protected $inputFilter;

    // Add content to this method:\
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->designation = (isset($data['designation'])) ? $data['designation'] : null;
        $this->eid = (isset($data['eid'])) ? $data['eid'] : null;
        $this->process = (isset($data['process'])) ? $data['process'] : null;
        $this->doj = (isset($data['doj'])) ? $data['doj'] : null;
        $this->period = (isset($data['period'])) ? $data['period'] : null;
        $this->complete = (isset($data['complete'])) ? $data['complete'] : '0'; //0 for not completed
        $this->pswd = (isset($data['pswd'])) ? $data['pswd'] : null; 
        $this->change_pswd = (isset($data['change_pswd'])) ? $data['change_pswd'] : '0'; 
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
