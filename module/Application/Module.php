<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Application\Model\Manager;
use Application\Model\ManagerTable;
use Application\Model\Employeeappraisal;
use Application\Model\EmployeeappraisalTable;
use Application\Model\Feedback;
use Application\Model\FeedbackTable;
use Application\Model\Hierarchy;
use Application\Model\HierarchyTable;
use Application\Model\Appraisal;
use Application\Model\AppraisalTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'mail.transport' => function ($serviceManager) {
                    $config = $serviceManager->get('Config'); 
                    $transport = new \Zend\Mail\Transport\Smtp();                
                    $transport->setOptions(new \Zend\Mail\Transport\SmtpOptions($config['mail']['transport']['options']));

                    return $transport;
                },
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : username and password
                    //that password hashed with sha1
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTable($dbAdapter,
                                              'manager','email','pwd', 'MD5(?)');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);

                    return $authService;
                },
		        'Application\Model\AuthStorage' => function($sm) {
                    return new \Application\Model\AuthStorage('manager');
                }, 
                'Application\Model\ManagerTable' => function($sm) {
                    $tableGateway = $sm->get('ManagerTableGateway');
                    $table = new ManagerTable($tableGateway);
                    return $table;
                },
                'ManagerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Manager());
                    return new TableGateway('manager', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\AppraisalTable' => function($sm) {
                    $tableGateway = $sm->get('AppraisalTableGateway');
                    $table = new AppraisalTable($tableGateway);
                    return $table;
                },
                'AppraisalTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Appraisal());
                    return new TableGateway('appraisal', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\EmployeeAppraisalTable' => function($sm) {
                    $tableGateway = $sm->get('EmployeeAppraisalTableGateway');
                    $table = new EmployeeappraisalTable($tableGateway);
                    return $table;
                },
                'EmployeeAppraisalTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Employeeappraisal());
                    return new TableGateway('employeeappraisal', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\Feedback' => function($sm) {
                    $tableGateway = $sm->get('FeedbackTableGateway');
                    $table = new FeedbackTable($tableGateway);
                    return $table;
                },
                'FeedbackTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Feedback());
                    return new TableGateway('feedback', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\HierarchyTable' => function($sm) {
                    $tableGateway = $sm->get('HierarchyTableGateway');
                    $table = new HierarchyTable($tableGateway);
                    return $table;
                },
                'HierarchyTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Hierarchy());
                    return new TableGateway('hierarchy', $dbAdapter, null, $resultSetPrototype);
                },
                        
            ),
        );
    }
}
