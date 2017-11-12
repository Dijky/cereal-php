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

abstract class AbstractBinaryOutputArchive extends BaseOutputArchive
{
    protected $packer;

    public function __construct(int $endianess = BinaryPacker::NativeEndian)
    {
        $this->packer = new BinaryPacker(BinaryPacker::NativeEndian, $endianess);
    }

    public function getOutEndianess() : int
    {
        return $this->packer->getOutEndianess();
    }

    abstract protected function _onProduce(string $data);

    protected function _saveNVP(NVP $value)
    {
        $this->save($value->value());
    }

    protected function _saveSizeTag(SizeTag $value)
    {
        $val = new UInt64($value->size());
        $result = $this->packer->pack($val);
        $this->_onProduce($result);
    }

    protected function _saveIntegral(Integral $value)
    {
        $result = $this->packer->pack($value);
        $this->_onProduce($result);
    }

    protected function _saveStr(Str $value)
    {
        $size = SizeTag::make($value->size());
        $this->_saveSizeTag($size);

        $result = $value->value();
        $this->_onProduce($result);
    }

    protected function _saveBinary(Binary $value)
    {
        $result = $this->packer->pack($value);
        $this->_onProduce($result);
    }
}
