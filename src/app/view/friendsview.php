<?php

namespace app\view;

use core\system\template\Template;

use app\model\User;

class FriendsView extends MenuView
{
    public function index()
    {
        $this->wall();
    }

    private function wall()
    {
        if ($this->values->hasKey('users'))
        {
            if (sizeof($this->users) > 0)
            {
                $this->template->profiles = '';
                foreach ($this->users as $user)
                {
                    $this->template->profiles .= $this->avatar($user);
                }
            }
        }
        $this->template->show($this->url->getActionPath(__FUNCTION__));
    }

    protected function avatar(User $user)
    {
        $template = new Template('avatar', 'friends');
        $template->image = $this->getAvatar($user);
        $template->username = $user->getUsername();
        $template->link = $this->url->build('profile', $user->getUsername());
        return $template;
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.friends.find"
     */
    protected function find()
    {
        $template = new FormWrapper('link.header.friends.find');
        $this->checkErrors($template);
        $template->render();
        $this->wall();
    }

    // TODO: is this even to be used anywhere?
    public function callUser()
    {
        $this->find();
    }
}

?>