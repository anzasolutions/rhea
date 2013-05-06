<?php

namespace core\controller;

use core\annotation\AnnotationClass;
use core\annotation\Annotation;
use core\form\FormFactory;
use core\form\exception\FormNotFoundException;
use core\form\validation\FormValidationException;
use core\system\Context;
use core\system\URL;
use core\system\container\Request;
use core\system\container\Values;
use core\system\session\SessionUser;
use core\util\TextBundle;

class ActionHandler
{
    const ERROR = 'error';

    private $action;
    private $class;
	private $method;
	private $form;
	private $values;
	private $request;
	private $bundle;

    public function __construct(Controller $controller)
    {
        $this->action = URL::getInstance()->getAction();
        $this->class = new AnnotationClass($controller);
		$this->values = Values::getInstance();
		$this->request = Request::getInstance();
		$this->bundle = TextBundle::getInstance();
		$this->processMethod();
		$this->processForm();
    }
    
    private function processMethod()
    {
        if (!$this->action)
        {
            $this->action = 'index';
        }
        
        if ($this->class->getObject()->hasMethod($this->action))
        {
            $this->method = $this->class->getMethod($this->action);
            if ($this->isReady())
            {
                return;
            }
        }
        $this->method = $this->class->getMethod(self::ERROR);
        $this->action = self::ERROR;
    }

    private function isReady()
    {
        return $this->isCallable()
            && $this->hasAnnotation(Annotation::INVOCABLE)
            && $this->isInCurrentContext()
            && $this->userHasPrivilege();
    }

    private function isCallable()
    {
        return !$this->method->getObject()->isPrivate();
    }

    private function hasAnnotation($annotation)
    {
        return $this->method->hasAnnotation($annotation);
    }

    /**
     * Check whether method of controller in application context
     * has context the same as the current one (Request or Session).
     */
    private function isInCurrentContext()
    {
        if ($this->class->hasAnnotation(Context::APPLICATION))
        {
            if ($this->method->hasOneOfAnnotations(Context::SESSION, Context::REQUEST))
            {
                $context = Context::getCurrent();
                return $this->hasAnnotation($context);
            }
        }
        return true;
    }

    // TODO: must support higher user role id allow user to execute methods with lower role ids
    // TODO: support multiple roles per action
    private function userHasPrivilege()
    {
        $user = SessionUser::getInstance();
        return $user->hasPrivilege($this->method);
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getDisplay()
    {
        return $this->isWebMethod() ? 'displayBare' : 'display';
    }

    /**
     * Check if current method is a webservice call.
     */
    private function isWebMethod()
    {
        return $this->hasAnnotation(Annotation::WEBMETHOD);
    }
    
    
    
    
    // TODO: most of the code below shuld be moved to a dedicated class FormHandler
    
    private function processForm()
    {
        if ($this->hasForm())
        {
            $this->createForm();
        }
    }
    
    private function createForm()
    {
        try
        {
            $type = $this->method->getValueOf(Annotation::FORM);
            $this->form = FormFactory::create($type);
            $this->request->checkSize();
        }
        catch (FormNotFoundException $e)
        {
            $this->values->error = $this->bundle->getText('form.validation.processing.problem');
        }
        catch (FormValidationException $e)
        {
//            $this->values->error = $this->bundle->getText('form.validation.invalid.value', $e->getMessage());
            
            $field = $e->getMessage() . 'Error';
            $this->values->$field = $this->bundle->getText('form.validation.invalid.value', $e->getMessage());
        }
        catch (\LengthException $e)
        {
            $this->values->error = $this->bundle->getText('form.message.error.file.too.big', $e->getMessage());
        }
    }
    
    public function hasForm()
    {
        return $this->hasAnnotation(Annotation::FORM);
    }
    
    public function getForm()
    {
        return $this->form;
    }
    
    public function getBeforeFormMethods()
    {
        $result = array();
        $type = $this->method->getValueOf(Annotation::FORM);
        $methods = $this->class->getMethods(Annotation::BEFORE_FORM);
        foreach ($methods as $method)
        {
            $beforeTypes = $method->getValuesOf(Annotation::BEFORE_FORM);
            if (in_array($type, $beforeTypes))
            {
                $result[] = $method->getName();
            }
        }
        return $result;
    }
}

?>