<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives\Traits;

trait StringInputTrait
{
    protected $data;

    protected function _traitInit(string &$data)
    {
        $this->data =& $data;
    }

    protected function _onConsume(int $size) : string
    {
        $res = substr($this->data, 0, $size);
        $this->data = substr($this->data, $size);
        return res;
    }
}
