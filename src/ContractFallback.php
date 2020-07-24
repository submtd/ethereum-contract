<?php

namespace Submtd\EthereumContract;

use stdClass;

class ContractFallback
{
    /**
     * Fallback.
     * @var \stdClass
     */
    public $fallback;

    /**
     * Class constructor.
     * @param \stdClass $fallback
     */
    public function __construct(stdClass $fallback)
    {
        $this->fallback = $fallback;
    }

    /**
     * Static constructor.
     * @param \stdClass $fallback
     * @return self
     */
    public static function init(stdClass $fallback) : self
    {
        return new static($fallback);
    }
}
