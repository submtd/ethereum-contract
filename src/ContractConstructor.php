<?php

namespace Submtd\EthereumContract;

use stdClass;

class ContractConstructor
{
    /**
     * Constructor.
     * @var \stdClass
     */
    public $constructor;

    /**
     * Class constructor.
     * @param \stdClass $constructor
     */
    public function __construct(stdClass $constructor)
    {
        $this->constructor = $constructor;
    }

    /**
     * Static constructor.
     * @param \stdClass $constructor
     * @return self
     */
    public static function init(stdClass $constructor) : self
    {
        return new static($constructor);
    }
}
