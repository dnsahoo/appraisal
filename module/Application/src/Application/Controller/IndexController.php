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
use Zend\Db\Adapter\Adapter;
use Zend\Mail;  
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage;

use Application\Model\Employeeappraisal;
use Application\Model\Manager;
use Application\Model\Hierarchy;
use Application\Model\Rating;
use Application\Model\Feedback;

class IndexController extends AbstractActionController {

    protected $mngrTable;
    protected $storage;
    protected $authservice;
    protected $empAprslTable;
    protected $hierarchyTable;
    protected $appraisalTable;
    protected $ratingTable;
    protected $feedbackTable;
    protected $dbAdapter;

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

    public function getSessionStorage() {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()->get('Application\Model\AuthStorage');
        }
        return $this->storage;
    }

    public function getAppraisalTable() {
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
            $config = $this->getServiceLocator()->get('Config');
            $this->dbAdapter = new Adapter($config['db']);
        }
        return $this->dbAdapter;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function appraisalAction() {
        //if already login, redirect to Dashboard 
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $this->layout('layout/appraisal');
        $email = $this->getSessionStorage()->getUserData('email');
        $emp_details = $this->getEmpAprslTable()->fetchAll(array('email' => $email));
        /*
         * get list of appraisal list
         */
        $role = $this->getSessionStorage()->getUserData('role');
        if ($emp_details->complete == 0)
            $appraisals = $this->getAppraisalTable()->fetchAll();
        else
            $appraisals = $this->getRatingTable()->getAppraisalRating($emp_details->id, $this->getDbAdapter());
        //$appraisals = $this->getAppraisalTable()->fetchAll();

        $request = $this->getRequest();
        if ($request->isPost()) {
            /*
             * update data into employee appraisal table
             */
            $data['period'] = $request->getPost('period');
            if ($emp_details->complete == 0) {
                $data['complete'] = '3';
            }
            $emp_id = $this->getEmpAprslTable()->updateEmpAprsl($data, $emp_details->id);

            /*
             * save into rating table
             * 
             * looping $appraisals data and save individual record into rating table
             */
            for ($i = 1; $i <= count($appraisals); $i++) {
                $r_data['emp_id'] = $emp_id;
                $r_data['aprsl_id'] = $request->getPost('self_rating_label_' . $i);
                $r_data['key_pointers'] = $request->getPost('key_pointers_' . $i);
                $r_data['aprsl_rate_id'] = $request->getPost('self_rating_' . $i);
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

            /**
             * Send email to Reporting Manger and Manager
             */
            //email code will be here
            $manageremail1 = $emp_details->mgr1_email;
            $manageremail2 = $emp_details->mgr2_email;

            // get the manager names from database
            $managername1 = $emp_details->mgr1_name;
            $managername2 = $emp_details->mgr2_name;

            //get the employee name
            $empname = $emp_details->name;

            if ($manageremail1 == 'NA' || $manageremail2 == 'NA') {
                $emailcount = 1;
            } else {
                $emailcount = 2;
            }

            // setup SMTP options  
            $options = new Mail\Transport\SmtpOptions(array(
                'name' => 'localhost',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => array(
                    'username' => 'appraisalglobal30@gmail.com',
                    'password' => 'indian@123',
                    'ssl' => 'tls',
                ),
            ));

            for ($c = 1; $c < $emailcount + 1; $c++) {
                $email = ${'manageremail' . $c};
                $mgrname = ${'managername' . $c};

                //email body
                $content = '<html>
			          <head>
					  </head>
					  <body>
					   <table cellspacing="0" cellpadding="5" width="100%" style="font-family:arial;font-size:12.8px;border:1px solid rgb(16,79,127)">
	                   <tbody>
						<tr>
							<td colspan="2" style="border-bottom-width:3px;border-bottom-style:solid;border-bottom-color:rgb(245,209,20);background:rgb(247,247,247);">
								<h2 style="margin:0px"><font color="#36b3b4">
									<img src="http://glo.globallogic.com/images/ta/logo.png" height="50px" alt="Talent Appraisal" title="Talent Appraisal" style="vertical-align:middle;margin-right:20px" class="CToWUd">
									</font><font color="#36b3b4">&nbsp;Talent&nbsp;</font>
									<span style="color:rgb(54,179,180);text-decoration:none">Appraisal</span>
									&nbsp;- CE</h2>
									</td>
									</tr>
									<tr>
									<td colspan="2" style="font-family:Arial;color:black"><table width="100%" style="border:1px dotted rgb(204,204,204);background:rgb(255,255,229)">
									<tbody>
									<tr>
									<td style="font-family:Arial;font-size:12px;font-weight:bold;padding:3px 10px">
									Hi ' . $mgrname . ',&nbsp;<br>
										<p>' . $empname . ' has submitted&nbsp;<span>appraisal</span>&nbsp;for your evaluation.</p>
										</td>
										</tr>
										<tr>
										<td>
										<p style="padding-left:7px;font-family:Arial;font-size:12px">Please login into the&nbsp;<a href="http://172.17.86.209/" target="_blank">Talent&nbsp;<span>Appraisal</span>&nbsp;- CE</a>
											&nbsp;system to review the same.
											</p>
											</td>
											</tr>
											</tbody>
											</table>
											</td>
											</tr>
											<tr>
											<td colspan="2">
												<hr style="background:rgb(16,79,127)"></td></tr><tr><td colspan="2" style="font-family:Arial;color:black;font-size:10px">This message was automatically generated. Please do not respond to this email.&nbsp;<span class="HOEnZb"><font color="#888888"><br><br></font></span>
												</td>
												</tr>
						</tbody>
						</table>
					  </body>
					  </html>
			           ';

                // make a header as html  
                $html = new MimePart($content);
                $html->type = "text/html";
                $body = new MimeMessage();
                $body->setParts(array($html,));

                // instance mail   
                $mail = new Mail\Message();
                $mail->setBody($body); // will generate our content 
                $mail->setFrom('hr@globallogic.com', 'GlobalLogic Talent Appraisal');
                $mail->setTo($email);
                $mail->setSubject('Talent Appraisal - CE');

                $transport = new Mail\Transport\Smtp($options);
                $transport->send($mail);
            }
            $this->flashMessenger()->setNamespace('success')
                    ->addMessage("You have succcessfuly submited your appraisal form.");
            return $this->redirect()->toRoute('appraisal');
        }

        $feedBack = $this->getFeedBackTable()->getFeedbackId('', $emp_details->id);
        $this->layout()->setVariable('feedBack', $feedBack);
        $this->layout()->setVariable('emp_details', $emp_details);
        $this->layout()->setVariable('role', $role);
        $this->layout()->setVariable('action', 'appraisal');
        $this->layout()->setVariable('appraisals', $appraisals);
    }

    /**
     * Review appraisal system
     */
    public function reviewAction() {
        //if already login, redirect to Dashboard 
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $this->layout('layout/appraisal');

        $emp_id = $this->params()->fromRoute('id');
        $role = $this->getSessionStorage()->getUserData('role');

        $request = $this->getRequest();
        if ($request->isPost()) {
            /**
             * Update Rating Table
             */
            $appraisals = $this->getRatingTable()->getAppraisalRating($emp_id, $this->getDbAdapter());
            foreach ($appraisals as $i => $val) {
                $i++;
                $r_data['id'] = $val['r_id'];
                //For Manager
                if ($role == 1) {
                    $r_data['comment'] = $request->getPost('comments_' . $i);
                    ;
                    $r_data['manager_ratting'] = $request->getPost('managers_rating_' . $i);
                }
                //For Reporting Manager
                if ($role == 2) {
                    $r_data['reporting_comment'] = $request->getPost('comments_' . $i);
                    ;
                    $r_data['reporting_rating'] = $request->getPost('managers_rating_' . $i);
                }
                $rting = new Rating();
                $rting->exchangeArray($r_data);
                $r_id = $this->getRatingTable()->save($rting);
            }
            /**
             * Update feedback Table
             * 
             * Here I use emp_id as Id of feedback table, bcuz, to avoid extra function.
             */
            $f_data['id'] = $emp_id;
            //For Manager
            if ($role == 1) {
                $f_data['e_manager_comment'] = $request->getPost('extra_mile_comments');
                $f_data['n_manager_comment'] = $request->getPost('notable_accom_comments');
                $f_data['overall_fb'] = $request->getPost('overall_feedback');
            }
            //for Reporting manager
            if ($role == 2) {
                $f_data['e_rpt_manager_comment'] = $request->getPost('e_rpt_manager_comment');
                $f_data['n_rpt_manager_comment'] = $request->getPost('n_rpt_manager_comment');
            }
            $fback = new Feedback();
            $fback->exchangeArray($f_data);
            $f_id = $this->getFeedBackTable()->save($fback);

            /**
             * Update completed in Employee appraisal
             */
            $e_data['id'] = $emp_id;
            if ($role == 1) {
                $e_data['complete'] = '1';
            } else if ($role == 2) {
                $e_data['complete'] = '2';
            } else {
                //nothing
            }

            $emp = new Employeeappraisal();
            $emp->exchangeArray($e_data);
            $emp_id = $this->getEmpAprslTable()->save($emp);

            /**
             * Send email to manager and Reporting manager
             */
            $this->flashMessenger()->setNamespace('success')
                    ->addMessage("Review has been saved successfully.");
            return $this->redirect()->toRoute('review', array('id' => $emp_id));
        }//end of if (post)

        $emp_details = $this->getEmpAprslTable()->getEmpById($emp_id);

        $mngr_email = $this->getSessionStorage()->getUserData('email');

        $feedBack = $this->getFeedBackTable()->getFeedbackId('', $emp_id);

        $appraisals = $this->getRatingTable()->getAppraisalRating($emp_id, $this->getDbAdapter());

        $this->layout()->setVariable('feedBack', $feedBack);
        $this->layout()->setVariable('emp_details', $emp_details);
        $this->layout()->setVariable('mngr_email', $mngr_email);
        $this->layout()->setVariable('role', 1);
        $this->layout()->setVariable('action', 'review/' . $emp_id);
        $this->layout()->setVariable('appraisals', $appraisals);
    }

}
