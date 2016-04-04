<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Rating {

    public $id;
    public $emp_id;
    public $aprsl_id;
    public $aprsl_rate_id;
    public $comment;
    public $key_pointers;
    protected $inputFilter;

    // Add content to this method:\
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->emp_id = (isset($data['emp_id'])) ? $data['emp_id'] : null;
        $this->aprsl_id = (isset($data['aprsl_id'])) ? $data['aprsl_id'] : null;
        $this->aprsl_rate_id = (isset($data['aprsl_rate_id'])) ? $data['aprsl_rate_id'] : null;
        $this->comment = (isset($data['comment'])) ? $data['comment'] : null;
        $this->key_pointers = (isset($data['key_pointers'])) ? $data['key_pointers'] : null;
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
