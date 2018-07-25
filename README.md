# injector

[![Build Status](https://travis-ci.com/jankovacs/injector.svg?branch=feature%2Fnew_version)](https://travis-ci.com/jankovacs/injector)

PHP Dependency Injector.
=======================

Simple example for usage:
------------------------

1) You have to specifiy somewhere in your system a config file for mappings, like this below:

```
class InjectionMappings {
     /**
     * @Inject
     * @var  \injector\api\IInjector
     */
    public $injector;
    public function setMappings()
    {
        //------- will always create a new instance
        $this->injector->map( TestModel::class );
        
        //------- will always create a new instance of the given type
        $this->injector->map( ITestModel::class )->toType( TestModelOne::class );
        
        //------- will return with the passed object
        $this->injector->map( TestModelOne::class )->toObject( new TestModelOne() );
        
        //------- will return with the singleton instance
        $this->injector->map( TestModelTwo::class )->asSingleton();
        
        //------- will return with the given singleton instance
        $this->injector->map( ITestSingleton::class )->toSingleton( TestSingleton::class );
        
        /** @var \injector\api\IInjectionProvider $providerMappings */
        $providerMappings = $this->injector->map( ITest::class )->toProvider( );
        $providerMappings->addUnique( 'SomeController' )->toSingleton( TestOne::class );
        //$providerMappings->addExceptTo( 'SomeController' )->toSingleton( TestTwo::class );
        $providerMappings->addToRest()->toSingleton( TestTwo::class );
        $this->injector->map( TestDetectDevice::class );
    }
}
```


2) Then you need to instantiate the injector and the the config file, inject the config file and set the mappings ( setMappings() method in the example above, but it could be named to whatever you want )
```
$injector = new \injector\impl\Injector();
$injectionMappings = new InjectionMappings();
$injector->inject( $injectionMappings );
$injectionMappings->setMappings();
```

3) Example for modifying your dispatcher class in Zend Framework 1 ( within your Bootstrap.php ). So thus your controllers will be injected.
```
protected function setDispatcher( )
{
    $injector = $this->setInjector();
    $dispatcher = new \injector\bridge\zf1\Dispatcher();
    $injector->inject( $dispatcher );
    $this->frontController->setDispatcher( $dispatcher );
}
```

4) This is how you can inject to your classes ( models, controllers,  etc. )
```
class IndexController
{
    /**
     * @Inject
     * @var injector\test\ITest
     */
    public $iTest;
    /**
     * @Inject
     * @var injector\test\ITestModel
     */
    public $iTestModel;
    /**
     * @Inject
     * @var injector\test\TestModelOne
     */
    public $testModelOne;
    /**
     * @Inject
     * @var injector\test\TestModelTwo
     */
    public $testModelTwo;
    /**
     * @Inject
     * @var injector\test\ITestSingleton
     */
    public $iTestSingleton;
    /**
     * @Inject
     * @var TestDetectDevice
     */
    public $mobileDetect;
}
```
