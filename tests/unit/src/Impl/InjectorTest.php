<?php
namespace src\Impl;

use JanKovacs\Injector\Api\IInjectionMapper;
use JanKovacs\Injector\Impl\Injector;

class InjectorTest extends \Codeception\Test\Unit
{

    protected const TEST_CLASS_NAME = TestClass::class;

    /** @var \UnitTester */
    protected $tester;

    /** @var \JanKovacs\Injector\Api\IInjector */
    protected $injector;

    /** @var \JanKovacs\Injector\Api\IInjectionMapper */
    protected $mapper;
    
    protected function _before()
    {
        $this->injector = new Injector();
        $this->mapper = $this->injector->map(self::TEST_CLASS_NAME);
    }

    protected function _after()
    {
    }


    public function testMapping()
    {
        $this->assertContainsOnlyInstancesOf(
            IInjectionMapper::class,
            [$this->mapper]
        );

    }

    public function testMappingWhenForTheSecondTimeTheMapIsCalled()
    {

        $mapper = $this->injector->map(self::TEST_CLASS_NAME);

        $this->assertContainsOnlyInstancesOf(
            IInjectionMapper::class,
            [$mapper]
        );
    }


    public function testGetInstance()
    {
        $instance = $this->injector->getInstance(self::TEST_CLASS_NAME);
        $this->assertContainsOnlyInstancesOf(
            self::TEST_CLASS_NAME,
            [$instance]
        );

    }
}

class TestClass
{

}