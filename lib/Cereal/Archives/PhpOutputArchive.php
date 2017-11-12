<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\NVP;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Binary;

class PhpOutputArchive extends BaseOutputArchive
{
    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function result() : string
    {
        return serialize($this->data);
    }

    protected function _saveNVP(NVP $value)
    {
        $this->save($value->value());
    }

    protected function _saveSizeTag(SizeTag $value)
    {
        // Do nothing
    }

    protected function _saveIntegral(Integral $value)
    {
        $v = null;
        $e = $value->value();
        $type = $value->type();

        switch ($type)
        {
            case Integral::Int8:
            case Integral::UInt8:
                $v = 0xFF & (int)$e;
                break;
            case Integral::Int16:
            case Integral::UInt16:
                $v = 0xFFFF & (int)$e;
                break;
            case Integral::Int32:
            case Integral::UInt32:
                $v = 0xFFFFFFFF & (int)$e;
                break;
            case Integral::Int64:
            case Integral::UInt64:
                $v = 0xFFFFFFFFFFFFFFFF & (int)$e;
                break;
            case Integral::Float:
                $v = (float)$e;
                break;
            case Integral::Double:
                $v = (double)$e;
                break;
            default:
                throw new Exception("Integral type '" . $type . "' unknown.");
        }

        array_push($this->data, $v);
    }

    protected function _saveStr(Str $value)
    {
        array_push($this->data, $value->value());
    }

    protected function _saveBinary(Binary $value)
    {
        $v = $value->value();
        Binary::resize($v, $value->size());
        array_push($this->data, $v);
    }
}
