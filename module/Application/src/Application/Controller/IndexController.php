<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Employeeappraisal;
use Application\Model\Manager;
use Application\Model\Hierarchy;

class IndexController extends AbstractActionController
{
    protected $mngrTable;
    protected $storage;
    protected $authservice;
    protected $empAprslTable;
    protected $hierarchyTable;
    protected $appraisalTable;
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
    public function getAppraisalTableTable() {
        if (!$this->appraisalTable) {
            $sm = $this->getServiceLocator();
            $this->appraisalTable = $sm->get('Application\Model\AppraisalTable');
        }
        return $this->appraisalTable;
    }
    public function getHierarchyTable() {
        if (!$this->hierarchyTable) {
            $sm = $this->getServiceLocator();
            $this->hierarchyTable = $sm->get('Application\Model\HierarchyTable');
        }
        return $this->mngrTable;
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
        return new ViewModel();
    }
    public function appraisalAction()
    {
        $this->layout('layout/appraisal');
        $request = $this->getRequest();
        if ($request->isPost()){
            print_r($request->getPost());
            die;
            //save data into employee appraisal table
            $data['name']       = $request->getPost('name');
            $data['email']      = $request->getPost('email');
            $data['eid']        = $request->getPost('globallogic_eid');
            $data['process']    = $request->getPost('process');
            $data['doj']        = $request->getPost('doj');
            $data['period']     = $request->getPost('period');
            $data['complete']   = 0; //for new record, its is 0
            
            $emp = new Employeeappraisal();
            
            $emp->exchangeArray($data);
            $emp_id = $this->getEmpAprslTable()->save($emp);
            //$name =$this->getSessionStorage()->getUserData('name');
            
            //save into manager table
            $mngr_data['email'] = $request->getPost('supervisor_or_manager_email');
            $mngr = new Manager();
            $mngr->exchangeArray($mngr_data);
            $mngr_id = $this->getManagerTable()->save($mngr_data);
            
            //save into hierarchy table
            $h_data['emp_id'] = $emp_id;
            $h_data['mngr_id'] = $mngr_id;
            $hierarchy = new Hierarchy();
            $hierarchy->exchangeArray($h_data);
            $h_id = $this->getHierarchyTable()->save($h_data);
            
            //save into rating table
            //looping this data for 8 times, because they have only 8 rating
            for($i = 0; $i < 8; $i++){
                $inx = '';
                if($i == 0)
                    $inx = '';
                else
                    $inx = $i;
                $r_data['aprsl_rate_id'] = $request->getPost('self_rating'.$inx);
                $r_data['key_points'] = $request->getPost('key_pointers'.$inx);
                
                $r_data['emp_id'] = $emp_id;
                //$r_data['aprsl_id'];
            }
            //$r_data[];
            
            //save into feedback table
            
            
        }
        //get list of appraisal list
        $appraisals = $this->getAppraisalTableTable()->fetchAll();
//        foreach ($appraisals as $key => $value) {
//            print_r($value);
//        }
        //die;
        $this->layout()->setVariable('role', 0);
        $this->layout()->setVariable('appraisals', $appraisals);
        
        return new ViewModel(array(
            
        ));
    }
}
