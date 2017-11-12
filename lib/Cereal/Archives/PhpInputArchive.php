<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\NVP;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Binary;

class PhpInputArchive extends BaseInputArchive
{
    private $data;

    public function __construct(string $data)
    {
        $this->data = unserialize($data);
    }

    protected function _loadNVP(NVP $value)
    {
        $this->load($value->value());
    }

    protected function _loadSizeTag(SizeTag $value)
    {
        // Do nothing
    }

    protected function _loadIntegral(Integral $value)
    {
        $v =& $value->value();
        $e = array_shift($this->data);

        switch ($value->type())
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
        }
    }

    protected function _loadStr(Str $value)
    {
        $v =& $value->value();
        $v = (string)array_shift($this->data);
    }

    protected function _loadBinary(Binary $value)
    {
        $v = array_shift($this->data);
        Binary::resize($v, $value->size());
        $val =& $value->value();
        $val = $v;
    }
}
