<?php

namespace app\controller;

use core\service\ServiceException;

use app\model\User;

use common\Mocker;

class AccountControllerTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    private $mocker;
    
    public function setUp()
    {
        $this->object = new AccountController();
        $this->mocker = new Mocker($this->object);
        $this->mocker->setTestCase($this);
        
        $this->service = $this->getMock('app\service\AccountService');
        $this->pool = $this->mocker->getNoConstructorMock('core\service\ServicePool');
        $request = $this->mocker->getNoConstructorMock('core\system\container\Request');
        $this->navigator = $this->getMock('core\util\Navigator');
        
        $this->mocker->mock('request', $request);
        $this->mocker->mock('service', $this->pool);
        $this->mocker->mock('navigator', $this->navigator);
    }
    
    /**
     * @test
     */
    public function userIsLoggedInProperly()
    {
        $login = 'one@two.com';
        $password = 'h4ck1nG';
        
        $session = $this->mocker->getNoConstructorMock('core\system\session\Session');
        $form = $this->mocker->getNoConstructorMock('app\form\LoginForm');
        
        $session->expects($this->once())
                ->method('start')
                ->will($this->returnValue(true));
        
        $this->service->expects($this->once())
                      ->method('login')
                      ->with($login, $password)
                      ->will($this->returnValue(new User()));
        
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $form->expects($this->once())
             ->method('getEmail')
             ->will($this->returnValue($login));
        
        $form->expects($this->once())
             ->method('getPassword')
             ->will($this->returnValue($password));
        
        $this->mocker->mock('session', $session);
             
        $this->object->login($form);
    }
    
    /**
     * @test
     */
    public function attemptToLoginIncorrectUserEndsWithException()
    {
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('login')
                      ->will($this->throwException(new ServiceException()));
        
        $form = $this->mocker->getNoConstructorMock('app\form\LoginForm');
        $bundle = $this->mocker->getNoConstructorMock('core\util\TextBundle');
        $values = $this->mocker->getNoConstructorMock('core\system\container\Values');
        
        $this->mocker->mock('bundle', $bundle);
        $this->mocker->mock('values', $values);
        
        $this->object->login($form);
    }
    
    /**
     * @test
     */
    public function passwordIsRecoveredProperly()
    {
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('recover');
        
        $form = $this->mocker->getNoConstructorMock('app\form\RecoverForm');
        
        $values = $this->mocker->getNoConstructorMock('core\system\container\Values');

        $bundle = $this->mocker->getNoConstructorMock('core\util\TextBundle');
        $bundle->expects($this->once())
               ->method('getText')
               ->with($this->equalTo('recover.message.success.password.sent'))
               ->will($this->returnValue('Success message'));
        
        $this->mocker->mock('bundle', $bundle);
        $this->mocker->mock('values', $values);
        
        $this->object->recover($form);
    }
    
    /**
     * @test
     */
    public function attemptToRecoverPasswordUsingIncorrectEmailEndsWithException()
    {
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('recover')
                      ->will($this->throwException(new ServiceException()));
        
        $form = $this->mocker->getNoConstructorMock('app\form\RecoverForm');
        $bundle = $this->mocker->getNoConstructorMock('core\util\TextBundle');
        $values = $this->mocker->getNoConstructorMock('core\system\container\Values');
        
        $this->mocker->mock('bundle', $bundle);
        $this->mocker->mock('values', $values);
        
        $this->object->recover($form);
    }
    
    /**
     * @test
     */
    public function accountIsActivatedSuccessfully()
    {
        $hash = 'e7715ead01db55ffbbe416d4c24ad4ef';
        
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('activate');
        
        $url = $this->mocker->getNoConstructorMock('core\system\URL');
        
        $url->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo(0))
            ->will($this->returnValue($hash));
        
        $this->mocker->mock('url', $url);
        
        $this->navigator->expects($this->once())
                        ->method('redirectTo')
                        ->with($this->equalTo('account'));
        
        $this->object->activate();
    }
    
    /**
     * @test
     */
    public function attemptToActivateAccountWithIncorrectHashEndsWithException()
    {
        $hash = 'e7715ead01db55ffbbe416d4c24ad4ef';
        
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('activate')
                      ->will($this->throwException(new ServiceException()));
        
        $url = $this->mocker->getNoConstructorMock('core\system\URL');
        
        $url->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo(0))
            ->will($this->returnValue($hash));
        
        $this->mocker->mock('url', $url);
        
        $this->navigator->expects($this->once())
                        ->method('redirectTo')
                        ->with($this->equalTo('account'));
        
        $this->object->activate();
    }
    
    /**
     * @test
     */
    public function accountIsRegisteredSuccessfully()
    {
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('register');
        
        $this->navigator->expects($this->once())
                        ->method('redirectTo')
                        ->with($this->equalTo('account/login'));
        
        $form = $this->mocker->getNoConstructorMock('app\form\RegisterForm');
        
        $this->object->register($form);
    }
    
    /**
     * @test
     */
    public function attemptToRegisterAccountEndsWithException()
    {
        $this->pool->expects($this->once())
                   ->method('__get')
                   ->with($this->equalTo('account'))
                   ->will($this->returnValue($this->service));
        
        $this->service->expects($this->once())
                      ->method('register')
                      ->will($this->throwException(new ServiceException()));
        
        $bundle = $this->mocker->getNoConstructorMock('core\util\TextBundle');
        $bundle->expects($this->once())
               ->method('getText');
        
        $values = $this->mocker->getNoConstructorMock('core\system\container\Values');
        $values->expects($this->once())
               ->method('__set')
               ->with($this->equalTo('error'));
        
        $this->mocker->mock('bundle', $bundle);
        $this->mocker->mock('values', $values);
        
        $form = $this->mocker->getNoConstructorMock('app\form\RegisterForm');
        
        $this->object->register($form);
    }
    
    /**
     * @test
     */
    public function userIsLoggedOutSuccessfully()
    {
        $this->navigator->expects($this->once())
                        ->method('redirectTo')
                        ->with($this->equalTo(null));
        
        $session = $this->mocker->getNoConstructorMock('core\system\session\Session');
        $session->expects($this->once())
                ->method('destroy')
                ->will($this->returnValue(true));
        
        $this->mocker->mock('session', $session);
        
        $this->object->logout();
    }
    
    /**
     * @test
     * @expectedException core\system\session\SessionException
     */
    public function attemptToLogoutEndsWithException()
    {
        $session = $this->mocker->getNoConstructorMock('core\system\session\Session');
        $session->expects($this->once())
                ->method('destroy')
                ->will($this->returnValue(false));
        
        $this->mocker->mock('session', $session);
        
        $this->object->logout();
    }
}

?>