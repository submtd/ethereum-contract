<?php

namespace Submtd\EthereumContract;

class Contract
{
    /**
     * Abi.
     * @var array
     */
    protected $abi;

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
        $this->abi = $abi;

        return $this;
    }

    /**
     * Get abi.
     * @return array
     */
    public function getAbi() : array
    {
        return $this->abi;
    }
}
