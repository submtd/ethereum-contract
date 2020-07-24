<?php

namespace Submtd\EthereumContract;

use stdClass;

class ContractEvent
{
    /**
     * Event.
     * @var \stdClass
     */
    public $event;

    /**
     * Class constructor.
     * @param \stdClass $event
     */
    public function __construct(stdClass $event)
    {
        $this->event = $event;
    }

    /**
     * Static constructor.
     * @param \stdClass $event
     * @return self
     */
    public static function init(stdClass $event) : self
    {
        return new static($event);
    }
}
