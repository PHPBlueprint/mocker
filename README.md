Code Generation

Within the docblock of a class or script, add the @example tag followed by the code you wish to use
as the template for following classes

```php
@example
class CLASSNAME extends \Namespace\Extended\Class {

}
```

Usage:
composer require blueprint/embrace

composer blueprint \Foo\Bar\Baz:Sample

Will create a template for a new Sample class using the template provided within the
\Foo\Bar\Baz class
