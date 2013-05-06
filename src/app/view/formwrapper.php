<?php

namespace app\view;

use core\system\URL;
use core\system\template\Template;
use core\util\TextBundle;

class FormWrapper extends Template
{
    public function __construct($title)
    {
        parent::__construct('form-wrapper', 'common');
        $url = URL::getInstance();
        $form = new Template($url->getAction(), $url->getController());
        $form->action = $url;
        $this->form = $form;
        $this->title = TextBundle::getInstance()->getText($title);
    }
}

?>