<?php

namespace app\form;

use core\form\AbstractForm;

/**
 * @ValidationUnit = "app\form\constant\ValidationRules"
 */
class NewPhotoForm extends AbstractForm
{
    /**
     * @ValidationRule = "NONE"
     */
    protected $file = 'file';

    /**
     * @Overrides
     */
    protected function bind()
    {
        $file = $this->request->getFile('file');
        if ($name = $file->getName())
        {
            $this->file = $name;
        }
    }

    public function getFile()
    {
        return $this->file;
    }
}

?>