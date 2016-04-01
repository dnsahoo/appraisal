<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Hierarchy {

    public $id;
    public $emp_id;
    public $mngr_id;
    protected $inputFilter;

    // Add content to this method:\
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : 0;
        $this->emp_id = (isset($data['emp_id'])) ? $data['emp_id'] : null;
        $this->mngr_id = (isset($data['mngr_id'])) ? $data['mngr_id'] : null;
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
