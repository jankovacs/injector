<?php

namespace injector\impl;


use injector\api\IInjector;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class Injector
 * @package injector\impl
 */
class Injector implements IInjector
{
    
    /**
     * @var array
     */
    private $mappings;

    public function __construct()
    {
        $this->mappings = array();
        $this->map( '\injector\api\IInjector' )->toObject( $this );
    }

    /**
     * @param $className the name of the class in string format
     * @return \injector\api\IInjectionMapper
     */
    public function map( $className )
    {
        return array_key_exists( $className, $this->mappings ) ? $this->mappings[ $className ] : $this->createMapping( $className );
    }

    /**
     * @param $className
     * @return \injector\api\IInjectionMapper
     */
    private function createMapping( $className )
    {
        $this->mappings[ $className ] = new ExtendedMapper( $className );
        return $this->mappings[ $className ];
    }

    /**
     * Returns with the instance of the requested class/type.
     * If it mapped as singleton, it will give back the single instance.
     * @param $className
     * @return mixed
     */
    public function getInstance( $className, $where = '' )
    {
        /** @var ExtendedMapper $injectionMapperInstance */
        $injectionMapperInstance = $this->getInjectionMapperInstance( $className );
        $instance = $injectionMapperInstance->getInstance( $where );
        if ( $injectionMapperInstance->isInjectable )
        {
            $this->inject( $instance );
        }
        return $instance;
    }

    /**
     * @param $className
     * @return InjectionMapper
     */
    private function getInjectionMapperInstance($className )
    {
        return array_key_exists( $className, $this->mappings ) && $this->mappings[ $className ] instanceof ExtendedMapper ?  $this->mappings[ $className ] : null;
    }

    public function inject( $instance )
    {
        $reflection = new ReflectionClass( $instance );
        $memberVariables = $reflection->getProperties( ReflectionProperty::IS_PUBLIC );
        $pattern = "/(@Inject)/";
        $replace = array( "/", " ", "*", "@Inject", "@var", "\n", "\r" );

        foreach( $memberVariables as $key=>$value )
        {
            $propertyName = $value->getName();
            $docComment = $value->getDocComment();
            $return_value = preg_match( $pattern, $docComment, $matches );
            if ( $return_value )
            {
                $instance->$propertyName = $this->getInstance( str_replace( $replace, '', $docComment ), $reflection->getName() );
            }
        }
    }
}