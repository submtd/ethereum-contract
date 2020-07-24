<?php

namespace Submtd\EthereumContract;

use Exception;

class Contract
{
    /**
     * Constructor.
     * @var \Submtd\EthereumContract\ContractConstructor
     */
    public $constructor;

    /**
     * Fallback.
     * @var \Submtd\EthereumContract\ContractFallback
     */
    public $fallback;

    /**
     * Functions.
     * @var array
     */
    public $functions = [];

    /**
     * Events.
     * @var array
     */
    public $events = [];

    /**
     * Class constructor.
     * @param array $abi
     */
    public function __construct(array $abi)
    {
        $this->setAbi($abi);
    }

    /**
     * Static constructor.
     * @param array $abi
     * @return self
     */
    public static function init(array $abi) : self
    {
        return new static($abi);
    }

    /**
     * Set abi.
     * @param array $abi
     * @return self
     */
    public function setAbi(array $abi) : self
    {
        foreach ($abi as $object) {
            switch ($object->type) {
                case 'constructor':
                    $this->constructor = ContractConstructor::init($object);
                    break;
                case 'fallback':
                    $this->fallback = ContractFallback::init($object);
                    break;
                case 'function':
                    $this->functions[$object->name] = ContractFunction::init($object);
                    break;
                case 'event':
                    $this->events[$object->name] = ContractEvent::init($object);
                    break;
            }
        }

        return $this;
    }

    /**
     * Get function.
     * @param string $name
     * @return \Submtd\EthereumContract\ContractFunction
     */
    public function getFunction(string $name) : ContractFunction
    {
        if (! isset($this->functions[$name])) {
            throw new Exception('Unknown function');
        }

        return $this->functions[$name];
    }

    /**
     * Get event.
     * @param string $name
     * @return \Submtd\EthereumContract\ContractEvent
     */
    public function getEvent(string $name) : ContractEvent
    {
        if (! isset($this->events[$name])) {
            throw new Exception('Unknown event');
        }

        return $this->events[$name];
    }

    /**
     * Encode request.
     * @param string $function
     * @param array $arguments
     * @return string
     */
    public function encode(string $function, array $arguments = []) : string
    {
        return $this->getFunction($function)->encode($arguments);
    }
}
