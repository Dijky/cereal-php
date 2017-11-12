<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives\Traits;

trait StreamOutputTrait
{
    protected $stream;

    protected function _traitInit($stream)
    {
        $this->stream = $stream;
    }

    protected function _onProduce(string $data)
    {
        $len = strlen($data);
        fwrite($this->stream, $data, $len);
    }
}
