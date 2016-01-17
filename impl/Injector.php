<?php

namespace injector\impl;


use injector\api\IInjector;
use ReflectionClass;
use ReflectionProperty;

class Injector implements IInjector
{
    /**
     * @var array
     */
    private $mappings;

    public function __construct()
    {
        $this->mappings = array();
        $this->map( IInjector::class )->toObject( $this );
    }

    /**
     * Maps the given class.
     * See \injector\api\IInjectionMapper for possibilities.
     * @param $className string the name of the class in string format
     * @return \injector\api\IInjectionMapper
     */
    public function map( $className )
    {
        $className = (string)$className;
        return array_key_exists( $className, $this->mappings ) ? $this->mappings[ $className ] : $this->createMapping( $className );
    }

    /**
     * Creates a mapping for the given class.
     * @param $className string the name of the class
     * @return \injector\api\IInjectionMapper
     */
    private function createMapping( $className )
    {
        return $this->mappings[ $className ] = new InjectionMapper( $className );
    }

    /**
     * Returns with the injected instance of the requested class/type.
     * If it is mapped as a singleton, it will give back the single instance.
     * @param $className string
     * @return mixed
     */
    public function getInstance( $className )
    {
        /** @var InjectionMapper $injectionMapper */
        $injectionMapper = $this->mappings[ $className ];
        $instance = $injectionMapper->getInstance();
        if ( $injectionMapper->getIsInjectable() )
        {
            $this->inject( $instance );
        }
        return $instance;
    }

    /**
     * Injects all defined dependencies to instantiated class passed as argument
     * @param $instance string the instantiated class what has to be injected
     * @return null
     */
    public function inject( $instance )
    {
        $reflection = new ReflectionClass( $instance );
        $memberVariables = $reflection->getProperties( ReflectionProperty::IS_PUBLIC );
        $pattern = "@Inject";
        $replace = array( "/", " ", "*", "@Inject", "@var", "\n", "\r" );

        foreach( $memberVariables as $key=>$value )
        {
            $propertyName = $value->getName();
            $docComment = $value->getDocComment();

            if ( strpos( $docComment, $pattern ) !== false )
            {
                $instance->$propertyName = $this->getInstance( str_replace( $replace, '', $docComment ) );
            }
        }
    }
}