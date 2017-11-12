<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\NVP;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Integral\UInt64;
use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Binary;
use \Dijky\Cereal\Util\BinaryPacker;

abstract class AbstractBinaryInputArchive extends BaseInputArchive
{
    protected $packer;

    public function __construct(int $endianess = BinaryPacker::NativeEndian)
    {
        $this->packer = new BinaryPacker($endianess, BinaryPacker::NativeEndian);
    }

    public function getInEndianess() : int
    {
        return $this->packer->getInEndianess();
    }

    abstract protected function _onConsume(int $size) : string;

    protected function _loadNVP(NVP $value)
    {
        $this->load($value->value());
    }

    protected function _loadSizeTag(SizeTag $value)
    {
        $val = new UInt64($value->size());
        $data = $this->_onConsume($val->size());
        $this->packer->unpack($data, $val);
    }

    protected function _loadIntegral(Integral $value)
    {
        $data = $this->_onConsume($value->size());
        $this->packer->unpack($data, $value);
    }

    protected function _loadStr(Str $value)
    {
        $size = SizeTag::make($value->size());
        $this->_loadSizeTag($size);

        $v =& $value->value();
        $v = $this->_onConsume($size->size());
    }

    protected function _loadBinary(Binary $value)
    {
        $data = $this->_onConsume($value->size());
        $this->packer->unpack($data, $value);
    }
}
