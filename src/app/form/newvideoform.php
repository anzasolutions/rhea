<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class NewVideoForm extends AbstractForm
{
    /**
     * @ValidationRule = "URL"
     */
    protected $link;

    public function getLink()
    {
        return $this->link;
    }
}

?>