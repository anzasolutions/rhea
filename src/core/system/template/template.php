<?php

namespace core\system\template;

use php\io\File;
use php\io\FileNotFoundException;
use php\io\FileReader;
use php\util\AbstractContainer;

use core\constant\FileSuffix;
use core\constant\Separator;

/**
 * Render template for display.
 * @author anza
 * @since 03-10-2010
 */
class Template extends AbstractContainer
{
    private $file;

    public function __construct($file = null, $folder = null)
    {
        $path = $this->getPath($file, $folder);
        $this->file = new File($path);
    }

    // FIXME: fix $folder = null
    public function show($file, $folder = null)
    {
        $path = $this->getPath($file, $folder);
        $this->file = new File($path);
        $this->render();
    }

    private function getPath($template, $folder = null)
    {
        if ($folder != null)
        {
            $template = $folder . Separator::SLASH . $template;
        }
        return PATH_ROOT . '/web/templates/' . $template . FileSuffix::HTML;
    }

    private function checkFileExists()
    {
        if (!$this->file->exists())
        {
            throw new FileNotFoundException($this->file->getPath());
        }
    }

    public function render()
    {
        echo $this->format();
    }

    public function format()
    {
        return $this->replaceTags();
    }

    public function __toString()
    {
        return $this->format();
    }

    private function replaceTags()
    {
        try
        {
            $this->checkFileExists();
            $content = new FileReader($this->file);
            $replacer = new TagReplacer($content, $this->values);
            return $replacer->replace();
        }
        catch (FileNotFoundException $e)
        {
            // TODO: i18n below
            return 'File ' . $this->file->getPath() . ' doesn\'t exists!';
        }
    }
}

?>
