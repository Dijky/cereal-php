<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Util\BinaryPacker;
use \Dijky\Cereal\Archives\Traits\StreamOutputTrait;

class StreamPortableBinaryOutputArchive extends AbstractPortableBinaryOutputArchive
{
    use StreamOutputTrait;

    public function __construct($stream, int $endianess = BinaryPacker::NativeEndian)
    {
        $this->_traitInit($stream);
        parent::__construct($endianess);
    }
}
