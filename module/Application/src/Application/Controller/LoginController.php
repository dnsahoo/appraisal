<?php 
namespace Application\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;

//use Application\Model\User;
 
class LoginController extends AbstractActionController
{
    protected $mngrTable;
    protected $storage;
    protected $authservice;
    protected $empAprslTable;
    protected $dbAdapter;
    

    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        } 
        return $this->authservice;
    }
    public function getSessionStorage()
    {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()->get('Application\Model\AuthStorage');
        }
        return $this->storage;
    }
    public function getManagerTable() {
        if (!$this->mngrTable) {
            $sm = $this->getServiceLocator();
            $this->mngrTable = $sm->get('Application\Model\ManagerTable');
        }
        return $this->mngrTable;
    }
    public function getEmpAprslTable() {
        if (!$this->empAprslTable) {
            $sm = $this->getServiceLocator();
            $this->empAprslTable = $sm->get('Application\Model\EmployeeAppraisalTable');
        }
        return $this->empAprslTable;
    }
    
    public function getDbAdapter() {
        if (!$this->dbAdapter) {
            $config = $this->getServiceLocator ()->get ( 'Config' );
            $this->dbAdapter = new Adapter($config['db']);
        }
        return $this->dbAdapter;
    }
    public function indexAction()
    {

        $this->layout('layout/login');
        //if already login, redirect to Dashboard 
	 if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('application');
        }
        $request = $this->getRequest();
        if ($request->isPost()){
                //check authentication...
                $pwdPassWord= md5($request->getPost('password'));
                
                // get the db adapter
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                
                // create auth adapter
                $authAdapter = new AuthAdapter($dbAdapter);
		//$select = $authAdapter->getDbSelect();
                // configure auth adapter
                $authAdapter->setTableName('manager')
                        ->setIdentityColumn('email')
                        ->setCredentialColumn('pwd');
                // pass authentication information to auth adapter
                $authAdapter->setIdentity($request->getPost('username'))
                        ->setCredential($pwdPassWord);
                $authService = new AuthenticationService();
                
                $authService->setAdapter($authAdapter);
                // authenticate
                $result = $authService->authenticate();
                
                if ($result->isValid()) {
                    $user_data = $this->getManagerTable()->fetchAll(array('email' => $request->getPost('username')))->current();
                    $userData = $authAdapter->getResultRowObject();
                    
                    $this->getSessionStorage()->setUserData($userData);
                    return $this->redirect()->toRoute('dashboard');
                }else{
                    $this->flashMessenger()->setNamespace('error')
                                           ->addMessage("The username and password is Incorrect.");
                    return $this->redirect()->toRoute('login');                }
        }
        return new ViewModel();
    }
    public function logoutAction() {
	$this->getSessionStorage()->forgetMe();
       $this->getAuthService()->clearIdentity();
       return $this->redirect()->toRoute('login');
    }
    public function dashboardAction() {

	if (!$this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        
        $mngr_id = $this->getSessionStorage()->getUserData('id');
        $role = $this->getSessionStorage()->getUserData('role');
        $email = $this->getSessionStorage()->getUserData('email');
        $empList = $this->getEmpAprslTable()->getEmpListByManagerId($mngr_id, $this->getDbAdapter());
        
        return new ViewModel(array(
            'empList' => $empList,
            'role' => $role,
            'email' => $email,
        ));
         
    }
}