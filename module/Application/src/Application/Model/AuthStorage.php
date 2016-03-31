<?php 
namespace Application\Model;
use Zend\Authentication\Storage;
use Zend\Session\Container; 
class AuthStorage extends Storage\Session
{
    public function setUserData($userData) {
        $user_session = new Container('user');
        $user_session->user_id = $userData->user_id;
        $user_session->username = $userData->username;
        $user_session->user_role = $userData->user_role;
        $user_session->name = $userData->name;
        $user_session->status = (int)$userData->status;
        return;
    }
    public function getUserData($index = '') {
        $value = '';

        if ($index != '' && $index != '') {
            $user_session = new Container('user');
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