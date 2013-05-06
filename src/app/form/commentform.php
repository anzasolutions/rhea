<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class CommentForm extends AbstractForm
{
    /**
     * @ValidationRule = "NONE"
     */
    protected $comment;
    
    /**
     * @ValidationRule = "NONE"
     */
    protected $type;
    
    /**
     * @ValidationRule = "NONE"
     */
    protected $id;

    public function getComment()
    {
        return $this->comment;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getId()
    {
        return $this->id;
    }
}

?>