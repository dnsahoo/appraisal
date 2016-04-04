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
use Application\Model\Rating;
use Application\Model\Feedback;

class IndexController extends AbstractActionController
{
    protected $mngrTable;
    protected $storage;
    protected $authservice;
    protected $empAprslTable;
    protected $hierarchyTable;
    protected $appraisalTable;
    protected $ratingTable;
    protected $feedbackTable;
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
        return $this->hierarchyTable;
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
    public function getRatingTable() {
        if (!$this->ratingTable) {
            $sm = $this->getServiceLocator();
            $this->ratingTable = $sm->get('Application\Model\RatingTable');
        }
        return $this->ratingTable;
    }
    public function getFeedBackTable() {
        if (!$this->feedbackTable) {
            $sm = $this->getServiceLocator();
            $this->feedbackTable = $sm->get('Application\Model\FeedbackTable');
        }
        return $this->feedbackTable;
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
        $appraisals = $this->getAppraisalTableTable()->fetchAll();
        $request = $this->getRequest();
        if ($request->isPost()){
            /*
             * save data into employee appraisal table
             */
            $data['name']       = $request->getPost('name');
            $data['email']      = $request->getPost('email');
            $data['eid']        = $request->getPost('globallogic_eid');
            $data['process']    = $request->getPost('process');
            $data['doj']        = date('Y-m-d', strtotime($request->getPost('doj')));
            $data['period']     = $request->getPost('period');
            $data['complete']   = 0; //for new record, its is 0
            $emp = new Employeeappraisal();
            
            $emp->exchangeArray($data);
            
            $emp_id = $this->getEmpAprslTable()->save($emp);
            /*
             * save into manager table
             */
            $mngr_data['email'] = $request->getPost('supervisor_or_manager_email');
            $mngr = new Manager();
            $mngr->exchangeArray($mngr_data);
            $mngr_id = $this->getManagerTable()->save($mngr);
            /*
             * save into hierarchy table
             */
            $h_data['emp_id'] = $emp_id;
            $h_data['mngr_id'] = $mngr_id;
            $hierarchy = new Hierarchy();
            $hierarchy->exchangeArray($h_data);
            $h_id = $this->getHierarchyTable()->save($hierarchy);
            /*
             * save into rating table
             * 
             * looping $appraisals data and save individual record into rating table
             */
            for($i = 1; $i <= count($appraisals); $i++){
                $r_data['emp_id']           = $emp_id;
                $r_data['aprsl_id']         = $request->getPost('self_rating_label_'.$i);
                $r_data['key_pointers']       = $request->getPost('key_pointers_'.$i);
                $r_data['aprsl_rate_id']    = $request->getPost('self_rating_'.$i);
                $rting = new Rating();
                $rting->exchangeArray($r_data);
                $r_id = $this->getRatingTable()->save($rting);
            }
            /*
             * save into feedback table
             */
            $f_data['emp_id'] = $emp_id;
            $f_data['major_resoponsbilties'] = $request->getPost('major_responsibilities');
            $f_data['extra_mile'] = $request->getPost('extra_mile');
            $f_data['notable_accomplishments'] = $request->getPost('notable_accomplishments');
            
            $fback = new Feedback();
            $fback->exchangeArray($f_data);
            $f_id = $this->getFeedBackTable()->save($fback);
            $this->flashMessenger()->setNamespace('success')
                                           ->addMessage("You have succcessfuly submited your appraisal form.");
            return $this->redirect()->toRoute('appraisal'); 
            
        }
        /*
         * get list of appraisal list
         */
        $this->layout()->setVariable('role', 0);
        $this->layout()->setVariable('appraisals', $appraisals);
        
        
    }
}
