<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Archives\Traits\StreamInputTrait;
use \Dijky\Cereal\Util\BinaryPacker;

class StreamBinaryInputArchive extends AbstractBinaryInputArchive
{
    use StreamInputTrait;

    public function __construct($stream, int $endianess = BinaryPacker::NativeEndian)
    {
        $this->_traitInit($stream);
        parent::__construct($endianess);
    }
}
