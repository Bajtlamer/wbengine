<?php
/**
 * Created by PhpStorm.
 * User: roza
 * Date: 22.09.17
 * Time: 16:28
 */

namespace Wbengine\Config;


class Value
{
    private $_value = null;
    private $_childrens = null;

    public function __construct($value)
    {
        $this->_value = $value;
        return $this;
    }

    public function __get($name)
    {
        if(is_object($this->_value)) {
            return (isset($this->_value->$name)) ? $this->_value->$name : null;
        }
        return $this->_value;
    }

    public function getChildrens(){
        if($this->isArray() === true){
            foreach ($this->_value as $value){
                $this->_childs[] = New self($value);
            }
            return $this->_childrens;
        }
        return array();
    }

    public function getValue(){
        if($this->isArray() === true){
            return $this->getChildrens();
        }else {
            return $this->_value;
        }
    }

    public function asString(){
        return (string) $this->getValue();
    }

    public function asInt(){
        return (int) $this->getValue();
    }

    public function asArray(){
        return (array) $this->getValue();
    }

    public function asObject(){
        return new \stdClass($this->getValue());
    }


    public function isArray(){
        return is_array($this->_value);
    }
}