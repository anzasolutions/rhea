<?php

namespace app\view;

class AccountView extends MenuView
{
    public function login()
    {
        $title = 'user.login.label.form.name';
        $template = new FormWrapper($title);
        $template->form->forgotUrl = $this->url->build('account', 'recover');
        $this->checkErrors($template);
        $template->render();
    }

    private function renderForm($title)
    {
        $template = new FormWrapper($title);
        $this->checkErrors($template);
        $template->render();
    }

    public function activate()
    {
    }

    public function recover()
    {
        $this->renderForm('user.recover.label.form.name');
    }

    public function register()
    {
        $this->renderForm('user.register.label.form.name');
    }
}

?>