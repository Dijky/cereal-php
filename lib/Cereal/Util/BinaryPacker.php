<?php declare(strict_types=1);

namespace Dijky\Cereal\Util;

use \Exception;
use \Dijky\Cereal\Packable;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Binary;

class BinaryPacker
{
    const NativeEndian = 0;
    const LittleEndian = 1;
    const BigEndian = 2;

    private $inEndianess;
    private $outEndianess;

    private static $packCodes = [
        Integral::Int8 => "c",
        Integral::UInt8 => "C",
        Integral::Int16 => "s",
        Integral::UInt16 => "S",
        Integral::Int32 => "l",
        Integral::UInt32 => "L",
        Integral::Int64 => "q",
        Integral::UInt64 => "Q",
        Integral::Float => "f",
        Integral::Double => "d"
    ];

    public function __construct(int $inEndianess = BinaryPacker::NativeEndian, int $outEndianess = BinaryPacker::NativeEndian)
    {
        $this->setInEndianess($inEndianess);
        $this->setOutEndianess($outEndianess);
    }

    public function setInEndianess(int $endianess)
    {
        if ($endianess === BinaryPacker::NativeEndian)
        {
            $endianess = self::nativeEndianess();
        }
        $this->inEndianess = $endianess;
    }

    public function setOutEndianess(int $endianess)
    {
        if ($endianess === BinaryPacker::NativeEndian)
        {
            $endianess = self::nativeEndianess();
        }
        $this->outEndianess = $endianess;
    }

    public function getInEndianess() : int
    {
        return $this->inEndianess;
    }

    public function getOutEndianess() : int
    {
        return $this->outEndianess;
    }

    public function pack(Packable $value) : string
    {
        if ($value instanceof Integral)
        {
            return $this->_packIntegral($value);
        }
        elseif ($value instanceof Binary)
        {
            return $this->_packBinary($value);
        }
        else
        {
            throw new Exception("Unsupported Packable type '" . get_class($value) . "'");
        }
    }

    public function unpack(string $data, Packable $value)
    {
        if ($value instanceof Integral)
        {
            return $this->_unpackIntegral($data, $value);
        }
        elseif ($value instanceof Binary)
        {
            return $this->_unpackBinary($data, $value);
        }
        else
        {
            throw new Exception("Unsupported Packable type '" . get_class($value) . "'");
        }
    }

    protected function _packIntegral(Integral $value) : string
    {
        $val = $value->value();
        $type = $value->type();

        if ($value->isInteger() || $value->isReal())
        {
            // Encodes in native endianess
            if (!array_key_exists($type, self::$packCodes))
            {
                throw new Exception("Unsuported numerical Integral type '" . $type . "'");
            }
            $code = self::$packCodes[$type];
            return $this->_swapBytes(pack($code, $val));
        }
        else
        {
            throw new Exception("Unsuported Integral type '" . $type . "'");
        }
    }

    protected function _unpackIntegral(string $data, Integral $value)
    {
        $type = $value->type();

        if (Integral::staticIsInteger($type) || Integral::staticIsReal($type))
        {
            // Encodes in native endianess
            if (!array_key_exists($type, self::$packCodes))
            {
                throw new Exception("Unsuported numerical Integral type '" . $type . "'");
            }
            $code = self::$packCodes[$type];
            $v =& $value->value();
            $res = unpack($code, $this->_swapBytes($data));
            $v = $res[1];
        }
        else
        {
            throw new Exception("Unsuported Integral type '" . $type . "'");
        }
    }

    protected function _packBinary(Binary $value) : string
    {
        $v = $value->value();
        Binary::resize($v, $value->size());
        return $v;
    }

    protected function _unpackBinary(string $data, Binary $value)
    {
        $v =& $value->value();
        Binary::resize($data, $value->size());
        $v = $data;
    }

    /**
     * Change endianess if native endianess does not match desired endianess.
     */
    protected function _swapBytes(string $data) : string
    {
        if ($this->inEndianess !== $this->outEndianess)
        {
            return strrev($data);
        }
        return $data;
    }

    public static function nativeEndianess() : int
    {
        static $result = null;
        if ($result === null)
        {
            $testint = 0x00FF;
            $p = pack('S', $testint);
            if ($testint === current(unpack('v', $p)))
                $result = BinaryPacker::LittleEndian;
            else
                $result = BinaryPacker::BigEndian;
        }
        return $result;
    }
}
