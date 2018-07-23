<?php
namespace Functional\Impl;

use Helper\Classes\ForProvider\ClassForProviderOne;
use Helper\Classes\ForProvider\ClassForProviderTwo;
use Helper\Classes\ForProvider\EndClasses\EndClassOne;
use Helper\Classes\ForProvider\EndClasses\EndClassThree;
use Helper\Classes\ForProvider\EndClasses\EndClassTwo;
use Helper\Classes\ForProvider\EndClasses\IEndClass;
use Helper\Classes\ITestOneClass;
use Helper\Classes\ITestSingletonClass;
use Helper\Classes\ITestTwoClass;
use Helper\Classes\TestOneClass;
use Helper\Classes\TestSingletonClass;
use Helper\Classes\TestTwoClass;
use Helper\Classes\ForProvider\IClassForProvider;
use JanKovacs\Injector\Impl\Injector;

class InjectorTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    /** @var \JanKovacs\Injector\Api\IInjector */
    protected $injector;


    protected function _before()
    {
        $this->injector = new Injector();
    }

    protected function _after()
    {
        $this->injector = null;
    }

    // tests
    public function testSimpleMapping()
    {
        $this->injector->map(TestOneClass::class);
        $instance = $this->injector->getInstance(TestOneClass::class);
        $this->assertContainsOnlyInstancesOf(
            TestOneClass::class,
            [$instance]
        );
    }


    public function testMapToType()
    {
        $this->injector->map(ITestOneClass::class)->toType(TestOneClass::class);
        $instance = $this->injector->getInstance(ITestOneClass::class);
        $this->assertContainsOnlyInstancesOf(
            TestOneClass::class,
            [$instance]
        );

    }

    public function testMapToObject()
    {
        $testClassTwo = new TestTwoClass();
        $this->injector->map(ITestTwoClass::class)->toObject($testClassTwo);
        $instance = $this->injector->getInstance(ITestTwoClass::class);
        $this->assertSame(
            $testClassTwo,
            $instance
        );
    }

    public function testAsSingleton()
    {
        $this->injector->map(TestSingletonClass::class)->asSingleton();
        $singletonOne = $this->injector->getInstance(TestSingletonClass::class);

        $singletonOne->setSomeValue(rand(0,1000));

        $singletonTwo = $this->injector->getInstance(TestSingletonClass::class);

        $this->assertSame(
            $singletonOne,
            $singletonTwo
        );

    }

    public function testMapToSingleton()
    {
        $this->injector->map(ITestSingletonClass::class)->toSingleton(TestSingletonClass::class);
        $singletonOne = $this->injector->getInstance(ITestSingletonClass::class);

        $singletonOne->setSomeValue(rand(0,1000));

        $singletonTwo = $this->injector->getInstance(ITestSingletonClass::class);

        $this->assertSame(
            $singletonOne,
            $singletonTwo
        );
    }


    public function testMapToProvider()
    {
        $provider = $this->injector->map(IClassForProvider::class)->toProvider();
        $provider->addUnique(EndClassOne::class)->toType(ClassForProviderOne::class);
        $provider->addToRest()->toType(ClassForProviderTwo::class);
        $provider->addUnique(EndClassThree::class)->toType(ClassForProviderOne::class);

        $this->injector->map(EndClassOne::class);
        $this->injector->map(EndClassTwo::class);
        $this->injector->map(EndClassThree::class);

        /** @var IEndClass $endClassOne */
        $endClassOne = $this->injector->getInstance(EndClassOne::class);
        /** @var IEndClass $endClassTwo */
        $endClassTwo = $this->injector->getInstance(EndClassTwo::class);
        /** @var IEndClass $endClassThree */
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
}