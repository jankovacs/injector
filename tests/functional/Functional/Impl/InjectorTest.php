<?php
namespace Functional\Impl;

use Helper\Classes\ForProvider\ClassForProviderOne;
use Helper\Classes\ForProvider\ClassForProviderTwo;
use Helper\Classes\ForProvider\EndClasses\EndClassOne;
use Helper\Classes\ForProvider\EndClasses\EndClassThree;
use Helper\Classes\ForProvider\EndClasses\EndClassTwo;
use Helper\Classes\ForProvider\EndClasses\EndClassInterface;
use Helper\Classes\NotMappedClass;
use Helper\Classes\NotMappedInterface;
use Helper\Classes\TestOneClassInterface;
use Helper\Classes\TestSingletonClassInterface;
use Helper\Classes\TestTwoClassInterface;
use Helper\Classes\TestOneClass;
use Helper\Classes\TestSingletonClass;
use Helper\Classes\TestTwoClass;
use Helper\Classes\ForProvider\ClassForProviderInterface;
use JanKovacs\Injector\Api\InjectorInterface;
use JanKovacs\Injector\Exceptions\InjectionMapperException;
use JanKovacs\Injector\Impl\Injector;

class InjectorTest extends \Codeception\Test\Unit
{
    /**
     *
     * @var \FunctionalTester
     */
    protected $tester;

    /**
     *
     * @var \JanKovacs\Injector\Api\InjectorInterface
     */
    protected $injector;


    /**
     * @return void
     */
    protected function _before()
    {
        $this->injector = new Injector();
    }

    /**
     * @return void
     */
    protected function _after()
    {
        $this->injector = null;
    }

    /**
     * @return void
     */
    public function testSimpleMapping():void
    {
        $this->injector->map(TestOneClass::class);
        $instance = $this->injector->getInstance(TestOneClass::class);
        $this->assertContainsOnlyInstancesOf(
            TestOneClass::class,
            [$instance]
        );
    }


    /**
     * @return void
     */
    public function testMapToType():void
    {
        $this->injector->map(TestOneClassInterface::class)->toType(TestOneClass::class);
        $instance = $this->injector->getInstance(TestOneClassInterface::class);
        $this->assertContainsOnlyInstancesOf(
            TestOneClass::class,
            [$instance]
        );

    }

    /**
     * @return void
     */
    public function testMapToObject():void
    {
        $testClassTwo = new TestTwoClass();
        $this->injector->map(TestTwoClassInterface::class)->toObject($testClassTwo);
        $instance = $this->injector->getInstance(TestTwoClassInterface::class);
        $this->assertSame(
            $testClassTwo,
            $instance
        );
    }

    /**
     * @return void
     */
    public function testAsSingleton():void
    {
        $this->injector->map(TestSingletonClass::class)->asSingleton();
        $singletonOne = $this->injector->getInstance(TestSingletonClass::class);

        $singletonOne->setSomeValue(rand(0, 1000));

        $singletonTwo = $this->injector->getInstance(TestSingletonClass::class);

        $this->assertSame(
            $singletonOne,
            $singletonTwo
        );

    }

    /**
     * @return void
     */
    public function testMapToSingleton():void
    {
        $this->injector->map(TestSingletonClassInterface::class)->toSingleton(TestSingletonClass::class);
        $singletonOne = $this->injector->getInstance(TestSingletonClassInterface::class);

        $singletonOne->setSomeValue(rand(0, 1000));

        $singletonTwo = $this->injector->getInstance(TestSingletonClassInterface::class);

        $this->assertSame(
            $singletonOne,
            $singletonTwo
        );
    }


    /**
     * @return void
     */
    public function testMapToProvider():void
    {
        $provider = $this->injector->map(ClassForProviderInterface::class)->toProvider();
        $provider->addUnique(EndClassOne::class)->toType(ClassForProviderOne::class);
        $provider->addToRest()->toType(ClassForProviderTwo::class);
        $provider->addUnique(EndClassThree::class)->toType(ClassForProviderOne::class);

        $this->injector->map(EndClassOne::class);
        $this->injector->map(EndClassTwo::class);
        $this->injector->map(EndClassThree::class);

        /** @var EndClassInterface $endClassOne */
        $endClassOne = $this->injector->getInstance(EndClassOne::class);

        /** @var EndClassInterface $endClassTwo */
        $endClassTwo = $this->injector->getInstance(EndClassTwo::class);

        /** @var EndClassInterface $endClassThree */
        $endClassThree = $this->injector->getInstance(EndClassThree::class);

        $this->assertContainsOnlyInstancesOf(
            ClassForProviderOne::class,
            [$endClassOne->getClassForProviderInstance()]
        );

        $this->assertContainsOnlyInstancesOf(
            ClassForProviderTwo::class,
            [$endClassTwo->getClassForProviderInstance()]
        );

        $this->assertContainsOnlyInstancesOf(
            ClassForProviderOne::class,
            [$endClassThree->getClassForProviderInstance()]
        );
    }


    /**
     * @return void
     */
    public function testNotMappedClass():void
    {
        $instance = $this->injector->getInstance(NotMappedClass::class);
        $this->assertContainsOnlyInstancesOf(
            NotMappedClass::class,
            [$instance]
        );
    }

    /**
     * @expectedException \JanKovacs\Injector\Exceptions\InjectionMapperException
     *
     * @return void
     */
    public function testNotMappedInterface():void
    {
        $this->injector->getInstance(NotMappedInterface::class);
    }


    /**
     * @return void
     */
    public function testInjectorMapped():void
    {
        $instance = $this->injector->getInstance(InjectorInterface::class);
        $this->assertContainsOnlyInstancesOf(
            Injector::class,
            [$instance]
        );
    }
}
