<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Util\BinaryPacker;
use \Dijky\Cereal\Archives\Traits\StringOutputTrait;

class StringPortableBinaryOutputArchive extends AbstractPortableBinaryOutputArchive
{
    use StringOutputTrait;

    public function __construct(string &$data, int $endianess = BinaryPacker::NativeEndian)
    {
        $this->_traitInit($data);
        parent::__construct($endianess);
    }
}
