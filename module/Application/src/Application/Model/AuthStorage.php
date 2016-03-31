<?php 
namespace Application\Model;
use Zend\Authentication\Storage;
use Zend\Session\Container; 
class AuthStorage extends Storage\Session
{
    public function setUserData($userData) {
        $user_session = new Container('manager');
        $user_session->id = $userData->id;
        $user_session->email = $userData->email;
        return;
    }
    public function getUserData($index = '') {
        $value = '';

        if ($index != '' && $index != '') {
            $user_session = new Container('manager');
            $value = $user_session->$index;
            if (!$value)
                $value = '';
        }

        return $value;
    }
    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }
}