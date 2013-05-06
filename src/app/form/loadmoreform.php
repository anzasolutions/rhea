<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class LoadMoreForm extends AbstractForm
{
    /**
     * @ValidationRule = "NONE"
     */
    protected $last;

    public function getLast()
    {
        return $this->last;
    }
}

?>