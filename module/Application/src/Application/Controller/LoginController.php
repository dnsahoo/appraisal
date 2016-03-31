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
                    return $this->redirect()->toRoute('application');
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
        $config = $this->getServiceLocator ()->get ( 'Config' );
        $clnts = $this->getClientTable()->fetchAll();
        $user_id = $this->getSessionStorage()->getUserData('user_id');
        $role = $this->getSessionStorage()->getUserData('user_role');
        $where=array('user_id' =>$user_id,'role'=>$role);
        $activity_log=$this->getActivityLogTable()->getActivityLog($where,$this->getDbAdapter());
        $count_unread_message=$this->getActivityLogTable()->getCountUnreadActivityLog($where,$this->getDbAdapter());
        $tmp_case = '';
        $tmp_ins = '';
        $tmp_clm = '';
        $tmp_ky = '';
        $nw_client_ary = array();
        foreach ($clnts as $ky => $client){
            
            if($tmp_case == $client['case_no'] && !empty($client['case_no'])
                    && $tmp_ins == $client['insurance_company'] && !empty($client['insurance_company'])){
                $tmp_clm = $client['claim_no']. ', ' . $tmp_clm;
                
                $nw_client_ary[$tmp_ky]['claim_no'] = $tmp_clm;
                continue;
            }else{
                $nw_client_ary[$ky] = $client;
                $tmp_ky = $ky;
            }
            
            $tmp_case = $client['case_no'];
            $tmp_ins = $client['insurance_company'];
            $tmp_clm = $client['claim_no'];
        }
        return new ViewModel(array(
            'clients' => $nw_client_ary,
            'role' => $role,
            'activity_log'=>$activity_log,
            'total_count'=>$count_unread_message
        ));
         
    }
}