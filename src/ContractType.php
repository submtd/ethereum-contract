<?php

namespace Submtd\EthereumContract;

use Exception;
use stdClass;

class ContractType
{
    /**
     * Indexed.
     * @var bool
     */
    public $indexed;

    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Type.
     * @var string
     */
    public $type;

    /**
     * Length.
     * @var int
     */
    public $length;

    /**
     * Class constructor.
     * @param \stdClass $type
     */
    public function __construct(stdClass $type)
    {
        $this->indexed = (isset($type->indexed) ? $type->indexed : false);
        $this->name = (isset($type->name) ? $type->name : null);
        $this->type = preg_replace('/[^a-z]/', '', $type->type);
        $this->length = preg_replace('/[^0-9]/', '', $type->type) ?? 64;
    }

    /**
     * Static constructor.
     * @param \stdClass $type
     * @return self
     */
    public static function init(stdClass $type) : self
    {
        return new static($type);
    }

    /**
     * Encode.
     * @param mixed $value
     * @return string
     */
    public function encode($value) : string
    {
        switch ($this->type) {
            case 'hash':
            case 'address':
                if (substr($value, 0, 2) === '0x') {
                    $value = substr($value, 2);
                }
                break;
            case 'uint':
            case 'int':
                $value = $this->decimalToHex($value);
                break;
            case 'bool':
                $value = $value === true ? 1 : 0;
                break;
            case 'string':
                $value = $this->stringToHex($value);
                break;
            default:
                throw new Exception('Invalid type');
        }

        return substr(str_pad(strval($value), 64, '0', STR_PAD_LEFT), 0, 64);
    }

    /**
     * Decode.
     * @param string $encoded
     * @return mixed
     */
    public function decode($value)
    {
        $value = ltrim($value, '0');
        switch ($this->type) {
            case 'hash':
            case 'address':
                $value = '0x'.$value;
                break;
            case 'uint':
            case 'int':
                $value = $this->hexToDecimal($value);
                break;
            case 'bool':
                $value = boolval($value);
                break;
            case 'string':
                $value = $this->hexToString($value);
                break;
            default:
                throw new Exception('Invalid type');
        }

        return $value;
    }

    /**
     * Decimal to hex.
     * @param mixed $value
     * @return string
     */
    private function decimalToHex($value) : string
    {
        $last = bcmod($value, 16);
        $remain = bcdiv(bcsub($value, $last), 16);
        if ($remain == 0) {
            return dechex($last);
        }

        return $this->decimalToHex($remain).dechex($last);
    }

    /**
     * Hex to decimal.
     * @param mixed $value
     * @return mixed
     */
    private function hexToDecimal($value)
    {
        $decimal = 0;
        $length = strlen($value);
        for ($i = 1; $i <= $length; $i++) {
            $decimal = bcadd($decimal, bcmul(strval(hexdec($value[$i - 1])), bcpow('16', strval($length - $i))));
        }

        return $decimal;
    }

    /**
     * String to Hex.
     * @param mixed $value
     * @return string
     */
    private function stringToHex($value) : string
    {
        $hex = '';
        for ($i = 0; $i < strlen($value); $i++) {
            $hex .= dechex(ord($value[$i]));
        }

        return $hex;
    }

    /**
     * Hex to string.
     * @param mixed $value
     * @return string
     */
    private function hexToString($value) : string
    {
        $string = '';
        for ($i = 0; $i < strlen($value) - 1; $i += 2) {
            $string .= chr(hexdec($value[$i].$value[$i + 1]));
        }

        return $string;
    }
}
