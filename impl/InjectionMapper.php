<?php

namespace injector\impl;
use injector\api\IInjectionMapper;

class InjectionMapper implements IInjectionMapper
{
    /**
     * @var string
     */
    private $_className;

    /**
     * @var string
     */
    private $_mappingType;

    /**
     * @var object
     */
    private $_instance;

    /**
     * @var Object
     */
    private $_object;

    /**
     * @var bool
     */
    private $_isInjectable;

    const JUST_INJECT = 'just_inject';
    const AS_SINGLETON = 'as_singleton';
    const TO_TYPE = 'to_type';
    const TO_OBJECT = 'to_object';

    public function __construct( $className )
    {
        $this->setClassName( $className );
        $this->_isInjectable = false;
        $this->setType( self::JUST_INJECT );
    }

    public function getMappingType()
    {
        return $this->_mappingType;
    }

    public function toType( $typeName )
    {
        $this->setClassName( $typeName );
        $this->setType( self::TO_TYPE );
    }
    public function toObject( $object )
    {
        $this->_object = $object;
        $this->setType( self::TO_OBJECT );
    }
    public function asSingleton( $typeName = '' )
    {
        if ( $typeName )
        {
            $this->setClassName( $typeName );
        }
        $this->setType( self::AS_SINGLETON );
    }

    private function setClassName( $className )
    {
        $this->_className = $className;
    }

    private function setType( $type )
    {
        $this->_mappingType = $type;
    }

    public function getInstance()
    {
        switch( $this->_mappingType )
        {
            case self::AS_SINGLETON:
                $this->setOrCreateSingleton();
                break;

            case self::TO_TYPE:
            case self::JUST_INJECT:
                $this->createNewInstance();
                break;

            case self::TO_OBJECT:
                $this->setObject();
                break;
        }

        return $this->_instance;
    }

    private function setOrCreateSingleton()
    {
        $this->_isInjectable = false;
        if ( !isset( $this->_instance ) )
        {
            $this->_isInjectable = true;
            $this->_instance = new $this->_className;
        }
    }

    private function createNewInstance()
    {
        $this->_instance = new $this->_className;
        $this->_isInjectable = true;
    }

    private function setObject()
    {
        $this->_isInjectable = !isset( $this->_instance );
        $this->_instance = $this->_object;
    }

    /**
     * Tells if an object is injectable
     * @return bool
     */
    public function getIsInjectable()
    {
        return $this->_isInjectable;
    }
}