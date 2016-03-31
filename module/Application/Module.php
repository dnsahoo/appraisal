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

use Application\Model\Manager;
use Application\Model\ManagerTable;

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
                    $resultSetPrototype = new \ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Manager());
                    return new TableGateway('manager', $dbAdapter, null, $resultSetPrototype);
                }
            ),
        );
    }
}
