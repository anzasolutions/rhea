<?php

namespace core\form;

use core\form\exception\FormNotFoundException;
use core\util\TextBundle;

final class FormFactory
{
    /**
     * Create requested Form Object.
     * @author anza
     * @param string $form Name of Form Object to be created.
     * @throws FormNotFoundException When impossible to find class of Form Object.
     * @return New Form Object if its class exists.
     */
    public static function create($form)
    {
        try
        {
            $form = 'app\form\\'.$form.'Form';
            if (class_exists($form))
            {
                return new $form();
            }
        }
        catch (\LogicException $e)
        {
            throw new FormNotFoundException(TextBundle::getInstance()->getText('form.validation.form.not.found', $fo));
        }
    }
}

?>