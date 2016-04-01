<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;   
use Zend\InputFilter\InputFilterInterface;  

class Manager
{
    public $id;
    public $email;
    public $pwd;
    public $role;
    protected $inputFilter; 
    // Add content to this method:\
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
        $this->pwd    = (isset($data['pwd'])) ? $data['pwd'] : null;
        $this->role    = (isset($data['role'])) ? $data['role'] : 1;
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'user_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}