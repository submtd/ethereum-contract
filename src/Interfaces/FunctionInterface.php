
<?php

namespace Submtd\EthereumContract\Interfaces;

interface FunctionInterface
{
    /**
     * name.
     * @return string
     */
    public function name() : string;

    /**
     * isConstant.
     * @return bool
     */
    public function isConstant() : bool;

    /**
     * isPayable.
     * @return bool
     */
    public function isPayable() : bool;

    /**
     * stateMutability.
     * @return string
     */
    public function stateMutability() : string;

    /**
     * inputs.
     * @return array
     */
    public function inputs() : array;

    /**
     * outputs.
     * @return array
     */
    public function outputs() : array;
}
