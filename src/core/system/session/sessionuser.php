<?php

namespace core\system\session;

use core\annotation\AnnotationObject;
use core\annotation\Annotation;

class SessionUser
{
    private static $instance;

    private $user;

    private function __construct()
    {
        $this->user = Session::get('user');
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function update($user)
    {
        Session::set('user', $user);
    }

    public function hasPrivilege(AnnotationObject $object)
    {
        if (!$object->hasAnnotation(Annotation::ROLE))
        {
            return true;
        }
        $value = $object->getValueOf(Annotation::ROLE);
        $role = $this->user->getRole()->getName();
        return $value == $role;
    }

    public function getUser()
    {
        return $this->user;
    }
}

?>