<?php

namespace Blueprint\Console\Commands;

use Composer\Script\Event;

/**
 * Embrace allows you to access easily scaffold your PHP code using
 * the @example docBlock comment
 *
 * @author Damien Rose <br0kenb1nary@users.noreply.github.com>
 */
class Embrace {

    protected $regex = [
        'openTag'   => '/^/',
        'example'   => '/(?<=@example\s).+?(?:)(?=)(?=@|\*\/)/ms',
        'uncomment' => '/^(.*?[*].*?)[^[\]]/m',
        'as'        => '/CLASSNAME/'
    ];
    protected $className;
    protected $mockTemplate;
    protected $mockExample;
    protected static $event;

    /**
     * Composer script constructor
     *
     * @param Event $event
     * @return \self
     */
    public static function execute(Event $event) {
        static::$event = $event;
        $split = $event->getArguments();
        list($class, $value) = explode(':', $split[0]);
        return new self($class, $value);
    }

    /**
     * Embrace constructor
     *
     * @param type $className
     * @param type $switches
     * @throws Exception
     */
    public function __construct($className, $switches) {
        $this->className = $switches;
        $reflection = new \ReflectionClass($className);
        if (!preg_match($this->regex['example'], $reflection->getDocComment(), $this->mockExample)) {
            throw new \Exception("{$this->className} is missing the required @example document comment tag.");
        }
        return $this->extractTemplate();
    }

    /**
     * Set file name for mock template
     *
     * @return string
     */
    public function newMockFileName(): string {
        return "{$this->className}.php";
    }

    /**
     * Replace call back closure
     *
     * @param type $value
     * @return \Closure
     */
    public function modifierClosure($value = null): \Closure {
        return function() use ($value) {
            return ($value) ?? $value;
        };
    }

    public function modifyTemplate(): string {
        return preg_replace_callback_array([
            $this->regex['openTag']   => $this->modifierClosure("<?php \n\n"),
            $this->regex['example']   => $this->modifierClosure(),
            $this->regex['uncomment'] => $this->modifierClosure(),
            $this->regex['as']        => $this->modifierClosure($this->className),
                ], $this->mockExample[0]);
    }

    /**
     * Write modified template to file
     *
     * @return \Event
     */
    public function extractTemplate() {
        file_put_contents($this->newMockFileName(), $this->modifyTemplate());
        return static::$event->getIO()->write("Created {$this->newMockFileName()}");
    }

}
