<?php

namespace Models;

use ErrorException;
use function json_encode;

/**
 * Class AnonymousElement
 * @package Models
 */
class AnonymousElement extends Formelement
{

    /**
     * @var object Encapsulating all the properties from real elements
     */
    private $properties = [];

    /**
     * @var bool Should this object be removed from the form?
     */
    private $deleted = false;

    /**
     * @return string|void
     * @throws ErrorException
     */
    public function get_html(){
        throw new ErrorException("AnonymousElement is only for a dummy object");
    }

    /**
     * @return array|void
     * @throws ErrorException
     */
    public function get_settings(){
        throw new ErrorException("AnonymousElement is only for a dummy object");
    }

    /**
     * Has this formelement been deleted?
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Return the data of this formelement as object similar to the object by Formelement::create
     *
     * @return object
     */
    public function export(){return null;}

    public function setData()
    {
        $this->data = json_encode($this->properties);
    }

    public function __get($name)
    {
        return $this->properties[$name];
    }

    public function __set($name, $value)
    {
        if ($name == 'deleted')
            $this->deleted = true;
        $this->properties[$name] = $value;
    }

}
