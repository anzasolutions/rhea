<?php

namespace core\annotation;

class Annotation
{
    private function __construct() {}

    const INVOCABLE = 'Invocable';
    const WEBMETHOD = 'WebMethod';
    const ROLE = 'Role';
    const MENU_ITEM = 'MenuItem';
    const MENU_BUNDLE = 'MenuBundle';
    const FETCH = 'Fetch';
    const FORM = 'Form';
    const BEFORE_FORM = 'BeforeForm';
    const POST_CONSTRUCT = 'PostConstruct';
    const ENTITY = 'Entity';
    const VALIDATION_UNIT = 'ValidationUnit';
    const VALIDATION_RULE = 'ValidationRule';
}

?>