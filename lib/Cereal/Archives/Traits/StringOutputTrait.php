<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives\Traits;

trait StringOutputTrait
{
    protected $data;

    protected function _traitInit(string &$data)
    {
        $this->data =& $data;
    }

    protected function _onProduce(string $data)
    {
        $this->data .= $data;
    }
}
