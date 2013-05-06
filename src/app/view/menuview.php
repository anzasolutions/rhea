<?php

namespace app\view;

use core\annotation\AnnotationClass;
use core\annotation\Annotation;
use core\constant\FileSuffix;
use core\constant\Separator;
use core\system\session\Session;
use core\system\session\SessionUser;
use core\system\template\Template;
use core\view\View;

use app\model\User;

abstract class MenuView extends View
{
    public function header()
    {
        $session = Session::getInstance();
        if ($session->isStarted())
        {
            $this->template->globalMenu = $this->createGlobalMenu();
            $this->template->contextMenu = $this->createContextMenu();
        }
        else
        {
            $this->template->globalMenu = $this->getWelcome();
        }
        $this->template->show(__FUNCTION__);
    }

    private function getWelcome()
    {
        $user = SessionUser::getInstance()->getUser();
        if ($user != null)
        {
            $template = new Template('menu-user-logged-in', 'common');
            $template->link = $this->url->build('profile', $user->getUsername());
            $template->credentials = $user->getUsername();
            $template->logout = $this->url->build('account', 'logout');
        }
        else
        {
            $template = new Template('menu-user-logged-out', 'common');
            $template->login = $this->url->build('account', 'login');
            $template->register = $this->url->build('account', 'register');
        }
        return $template;
    }

    protected function getAvatar(User $user)
    {
        if ($user->hasAvatar())
        {
            return URL_PHOTOS . $user->getId() . Separator::SLASH . 'avatar' . FileSuffix::JPG;
        }
        return $avatar = URL_STATIC . 'web/images/avatar-2'.FileSuffix::PNG;
    }

    private function createGlobalMenu()
    {
        $template = new Template('menu-global', 'common');
        $links = array('friends', 'video', 'photo', 'shop');
        foreach ($links as $link)
        {
            $template->$link = $this->url->build($link);
        }
        $user = SessionUser::getInstance()->getUser();
        if ($user->getRole()->getId() == 1)
        {
            $template->stock = $this->url->build('stock');
        }
        $template->userSection = $this->getWelcome();
        return $template;
    }
    
    protected function createContextMenu()
    {
        $class = new AnnotationClass($this);
        $result = $class->getMethods(Annotation::MENU_ITEM);
        if (sizeof($result) == 0)
        {
            return;
        }
        $links = array();
        foreach ($result as $link)
        {
            $element['link'] = $this->url->build($this->url->getController(), $link->getShortName());
            $element['title'] = $link->hasAnnotation(Annotation::MENU_BUNDLE) ? $this->bundle->getText($link->getValueOf(Annotation::MENU_BUNDLE)) : $link->getName();
            $links[] = $element;
        }
        $template = new Template('menu-context', 'common');
        $template->links = $links;
        return $template;
    }

    protected function checkErrors(Template $template = null)
    {
        if ($template == null)
        {
            $template = $this->template;
        }
        
        if ($this->values->hasKey('error'))
        {
            $template->message = $this->error;
        }
        
        if ($template->hasKey('form'))
        {
            foreach ($_POST as $key => $value)
            {
                $template->form->$key = $value;
                if ($this->values->hasKey($key . 'Error'))
                {
                    $fieldError = $key . 'Error';
                    $template->form->$fieldError = $this->values->$fieldError;
                }
            }
        }
    }
}

?>