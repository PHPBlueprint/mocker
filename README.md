# PHPBlueprint - Mocker Component

Easily create and deploy code without rewriting common structures

> Create mockable templates for any PHP code and easily deploy new class structures, models, components, etc.

### Installation/Setup

Install the mocker component using composer

```sh
$ composer require phpblueprint/mocker
```

Easily create a blueprint of existing classes by added a basic @example tag to the document header

```php
/**
 * Class documentation haeder example
 *
 * @example
 * class CLASSNAME extends \Blueprint\Http\Rest\Client {
 *      protected $param = 'FOO';
 *      public function __construct() {
 *
 *      }
 * }
 *
 * @author Damien Rose <br0kenb1nary@users.noreply.github.com>
 */
```

### Usage

To create a new mocker of that class, run the blueprint command with the namespace\class that contains the template document header : the name of the new class you are creating

```sh
composer blueprint \Namespace\With\Class:NewClassName
```

Once done, your root directory will contain a new file with mocked code template.

### TODO
- improve code cleanliness
- add default namespace support
- add shortname support
- add config options to PHPBlueprint json
- 

If you plan on using PHPBlueprint, any of its components, or if you plan on designing new components following the PHPBlueprint concept, share it and make sure to include PHPBlueprint in a mention or contributor thanks.
