<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Types\Integral\UInt8;
use \Dijky\Cereal\Util\BinaryPacker;

abstract class AbstractPortableBinaryInputArchive extends AbstractBinaryInputArchive
{
    public function __construct(int $endianess = BinaryPacker::NativeEndian)
    {
        parent::__construct(BinaryPacker::NativeEndian);
        $this->packer->setOutEndianess($endianess);
        $this->_init();
    }

    protected function _init()
    {
        $isLittleEndian = 0;
        $this->_loadIntegral(new UInt8($isLittleEndian));
        $this->packer->setInEndianess(
            $isLittleEndian ? BinaryPacker::LittleEndian : BinaryPacker::BigEndian
        );
    }
}
