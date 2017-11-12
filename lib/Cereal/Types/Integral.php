<?php declare(strict_types=1);

namespace Dijky\Cereal\Types;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\DefaultConstructible;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Packable;
use \Exception;

abstract class Integral implements Serializable, Packable, DefaultConstructible
{
    const Bool = 1;
    const Int8 = 1;
    const UInt8 = 2;
    const Int16 = 3;
    const UInt16 = 4;
    const Int32 = 5;
    const UInt32 = 6;
    const Int64 = 7;
    const UInt64 = 8;
    const Float = 9;
    const Double = 10;

    private static $sizes = [
        Integral::Int8 => 1,
        Integral::UInt8 => 1,
        Integral::Int16 => 2,
        Integral::UInt16 => 2,
        Integral::Int32 => 4,
        Integral::UInt32 => 4,
        Integral::Int64 => 8,
        Integral::UInt64 => 8,
        Integral::Float => 4,
        Integral::Double => 8
    ];

    protected static $type = null;
    private $value;

    public function __construct(&$value = null)
    {
        $this->value =& $value;
        $type = static::$type;

        if (
            ($type === Integral::Int64 || $type === Integral::UInt64)
            && PHP_INT_SIZE < 8
        )
        {
            throw new Exception("Integral::Int64 and Integral::UInt64 require 64bit PHP");
        }
    }

    public static function make($value = null) : Integral
    {
        return new static($value);
    }

    public function load(BaseInputArchive $ar)
    {
        throw new Exception("Integral load needs to be implemented by InputArchive");
    }

    public function save(BaseOutputArchive $ar)
    {
        throw new Exception("Integral save needs to be implemented by OutputArchive");
    }

    public static function type() : int
    {
        return static::$type;
    }

    public function &value()
    {
        return $this->value;
    }

    public function size() : int
    {
        return self::$sizes[static::type()];
    }

    public static function staticIsInteger(int $type) : bool
    {
        return $type >= Integral::Int8 && $type <= Integral::UInt64;
    }

    public function isInteger() : bool
    {
        return static::staticIsInteger(static::type());
    }

    public static function staticIsReal(int $type) : bool
    {
        return $type === Integral::Float || $type === Integral::Double;
    }

    public function isReal() : bool
    {
        return static::staticIsReal(static::type());
    }
}
