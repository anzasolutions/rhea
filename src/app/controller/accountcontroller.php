<?php

namespace app\controller;

use core\controller\Controller;
use core\service\ServiceException;
use core\system\session\Session;
use core\system\session\SessionException;
use core\system\session\SessionUser;

use app\model\User;

/**
 * @Application
 */
class AccountController extends Controller
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->session->isStarted() ? $this->setAction('edit') : $this->setAction('login');
    }

    /**
     * @Invocable
     * @Request
     * @Form = "login"
     */
    public function login($form)
    {
        try
        {
            $email = $form->getEmail();
            $password = $form->getPassword();
            $user = $this->service->account->login($email, $password);
            $this->startSession($user);
            	
            // TODO: here's an idea: registration process can be simplify in a way that
            // user is able to provide only most necessary values and the rest like
            // firstname or lastname can be provided later with profile edition.
            // However the user should be 'poked' with a message to fill in profile details.
            // Question is: should that happen on visit check (one time info) or
            // everytime while firstname and/or lastname (and others) aren't filled.
            // If one time check happens maybe the workflow should go to a welcome-like
            // screen and ask kindly to fill profile/account data in?
            	
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('auth.message.invalid.user');
        }
    }

    private function startSession(User $user)
    {
        if ($this->request->hasKey('remember'))
        {
            $this->session->setRemembered(true);
        }
        $this->session->start();
        SessionUser::update($user);
        $this->redirectTo();
    }

    /**
     * @Invocable
     * @Request
     * @Form = "recover"
     */
    public function recover($form)
    {
        try
        {
            $this->service->account->recover($form->getEmail());
            $this->success = $this->bundle->getText('recover.message.success.password.sent');
            $this->redirectTo('account/login');
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('recover.message.error.invalid.email', $form->getEmail());
        }
    }

    /**
     * @Invocable
     * @Request
     */
    public function activate()
    {
        try
        {
            $activeHash = $this->validateActiveHash();
            $this->service->account->activate($activeHash);
        }
        catch (ServiceException $e)
        {
        }
        $this->redirectTo('account');
    }

    /**
     * Check activation hash exists.
     * @return string Activation hash.
     */
    private function validateActiveHash()
    {
        $activeHash = $this->url->getParameter(0);
        if ($activeHash == null)
        {
            $this->redirectToError();
        }
        return $activeHash;
    }

    /**
     * @Invocable
     * @Request
     * @Form = "register"
     */
    public function register($form)
    {
        try
        {
            $username = $form->getUsername();
            $email = $form->getEmail();
            $password = $form->getPassword();
            $this->service->account->register($username, $email, $password);
            $this->redirectTo('account/login');
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('form.validation.login.taken', $e->getMessage());
        }
    }

    /**
     * @Invocable
     * @Session
     */
    public function logout()
    {
        $destroyed = $this->session->destroy();
        if (!$destroyed)
        {
            throw new SessionException('Cannot destroy session!');
        }
        $this->redirectTo();
    }
}

?>