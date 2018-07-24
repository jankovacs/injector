Lightweight PHP Dependency Injector
=======================

Injects the class dependencies based on constructor signature.
Native types are not supported as dependencies (like int, array, string etc.) as into constructor one should pass just dependencies to other classes, not concrete data, e.g. 'locale' - that could be retrieved from a config class.

_Singleton support is kept, but it is not recommended to use singletons._

Simple example for usage:
------------------------

1) You have to specify somewhere in your application a config file for mappings, like this below:

```

class InjectionMappings {

    public function __construct(IInjector $injector)
    {
        $this->injector = $injector;
    }


    public function setMappings()
    {
        //------- will always create a new instance
        $this->injector->map( TestModel::class );
        
        //------- will always create a new instance of the mapped type
        $this->injector->map( ITestModel::class )->toType( TestModelOne::class );
        
        //------- will return with the mapped object
        $this->injector->map( TestModelOne::class )->toObject( new TestModelOne() );
        
        //------- will return with the singleton instance
        $this->injector->map( TestModelTwo::class )->asSingleton();
        
        //------- will return with the mapped class as singleton
        $this->injector->map( ITestSingleton::class )->toSingleton( TestSingleton::class );
        
        //------- example for unsing provider
        //------- 
        //------- it is for having more complex mapping logic
        //------- you can map eg. an Interface to different end classes as different implementations
        //------- be carefull, a not proper use can lead to misbehavior of your application
        //------- 
        //------- in this example the TestOne class will be injected to SomeController only
        //------- in all other classes, where the ITest is required, the TestTwo will be injected
        /** @var \injector\api\IInjectionProvider $providerMappings */
        $providerMappings = $this->injector->map( ITest::class )->toProvider( );
        $providerMappings->addUnique( 'SomeController' )->toSingleton( TestOne::class );
        //$providerMappings->addExceptTo( 'SomeController' )->toSingleton( TestTwo::class );
        $providerMappings->addToRest()->toSingleton( TestTwo::class );
    }
}

```

2) Then you need to instantiate the injector and the mapper classes and set the mappings ( setMappings() method in the example above, but it could be named to whatever you want )
```
// create injector
$injector = new \injector\impl\Injector();
// map you injection mapping class
$injector->map(InjectionMappings::class);
// get the intantiated mapper class from injector (it will be injected in this way)
$injectionMappings = $injector->getInstance(InjectionMappings::class);
// set the mappings
$injectionMappings->setMappings();
```

3) This is how you can inject dependencies into your classes
```
class IndexController
{
    public function __construct(ITestModel $testModel, ITestSingleton $testSingletion) 
    {
    
    }
}
```

_You don't need to rewrite your code by adding some injector specific stuff (like in the initial version of this injector), it is injecting the needed dependencies by the constructor signature._
