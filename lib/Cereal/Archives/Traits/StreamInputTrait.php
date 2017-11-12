<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives\Traits;

use \Exception;

trait StreamInputTrait
{
    protected $stream;

    protected function _traitInit($stream)
    {
        $this->stream = $stream;
    }

    protected function _onConsume(int $size) : string
    {
        $result = "";
        while ($size)
        {
            if (feof($this->stream))
            {
                throw new Exception("Input stream reached EOF prematurely");
            }
            $result .= $out = fread($this->stream, $size);
            $size -= strlen($out);
        }
        return $result;
    }
}
