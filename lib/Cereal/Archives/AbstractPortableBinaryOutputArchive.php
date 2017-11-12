<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Types\Integral\UInt8;
use \Dijky\Cereal\Util\BinaryPacker;

abstract class AbstractPortableBinaryOutputArchive extends AbstractBinaryOutputArchive
{
    public function __construct(int $endianess = BinaryPacker::NativeEndian)
    {
        parent::__construct($endianess);
        $this->_init();
    }

    protected function _init()
    {
        $isLittleEndian = $this->packer->getOutEndianess() === BinaryPacker::LittleEndian ? 1 : 0;
        $this->_saveIntegral(UInt8::make($isLittleEndian));
    }
}
