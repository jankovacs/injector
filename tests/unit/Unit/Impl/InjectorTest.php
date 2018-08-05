<?php
namespace Unit\Impl;

use JanKovacs\Injector\Api\InjectionMapperInterface;
use JanKovacs\Injector\Impl\Injector;
use Helper\Classes\TestOneClass;

class InjectorTest extends \Codeception\Test\Unit
{

    protected const TEST_CLASS_NAME = TestOneClass::class;

    /**
     *
     * @var \UnitTester 
     */
    protected $tester;

    /**
     *
     * @var \JanKovacs\Injector\Api\InjectorInterface
     */
    protected $injector;

    /**
     *
     * @var \JanKovacs\Injector\Api\InjectionMapperInterface
     */
    protected $mapper;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->injector = new Injector();
        $this->mapper = $this->injector->map(self::TEST_CLASS_NAME);
    }

    /**
     * @return void
     */
    protected function _after()
    {
        $this->injector = null;
        $this->mapper = null;
    }


    /**
     * @return void
     */
    public function testMapping():void
    {
        $this->assertContainsOnlyInstancesOf(
            InjectionMapperInterface::class,
            [$this->mapper]
        );

    }

    /**
     * @return void
     */
    public function testMappingWhenForTheSecondTimeTheMapIsCalled():void
    {

        $mapper = $this->injector->map(self::TEST_CLASS_NAME);

        $this->assertContainsOnlyInstancesOf(
            InjectionMapperInterface::class,
            [$mapper]
        );
    }


    /**
     * @return void
     */
    public function testGetInstance():void
    {
        $instance = $this->injector->getInstance(self::TEST_CLASS_NAME);
        $this->assertContainsOnlyInstancesOf(
            self::TEST_CLASS_NAME,
            [$instance]
        );

    }
}
