<?php

namespace Submtd\EthereumContract;

use Exception;
use kornrunner\Keccak;
use stdClass;

class ContractFunction
{
    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Constant.
     * @var bool
     */
    public $constant;

    /**
     * Payable.
     * @var bool
     */
    public $payable;

    /**
     * State mutability.
     * @var string
     */
    public $stateMutability;

    /**
     * Inputs.
     * @var array
     */
    public $inputs = [];

    /**
     * Outputs.
     * @var array
     */
    public $outputs = [];

    /**
     * Class constructor.
     * @param \stdClass $function
     */
    public function __construct(stdClass $function)
    {
        $this->setFunction($function);
    }

    /**
     * Static constructor.
     * @param \stdClass $function
     * @return self
     */
    public static function init(stdClass $function) : self
    {
        return new static($function);
    }

    /**
     * Set function.
     * @param \stdClass $function
     * @return self
     */
    public function setFunction(stdClass $function) : self
    {
        $this->name = $function->name;
        $this->constant = $function->constant;
        $this->payable = $function->payable;
        $this->stateMutability = $function->stateMutability;
        foreach ($function->inputs as $input) {
            $this->inputs[] = ContractType::init($input);
        }
        foreach ($function->outputs as $output) {
            $this->outputs[] = ContractType::init($output);
        }

        return $this;
    }

    /**
     * Encode request.
     * @param array $arguments
     * @return string
     */
    public function encode(array $arguments = []) : string
    {
        $inputCount = count($this->inputs);
        $argumentCount = count($arguments);
        if ($inputCount != $argumentCount) {
            throw new Exception('Incorrect number of arguments');
        }
        $encoded = '';
        $types = [];
        for ($i = 0; $i < $inputCount; $i++) {
            $encoded .= $this->inputs[$i]->encode($arguments[$i]);
            $types[] = $this->inputs[$i]->type;
        }
        $encodedCall = Keccak::hash(sprintf('%s(%s)', $this->name, implode(',', $types)), 256);

        return '0x'.substr($encodedCall, 0, 8).$encoded;
    }
}
