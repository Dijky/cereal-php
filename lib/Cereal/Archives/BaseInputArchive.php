<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\NVP;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Binary;

abstract class BaseInputArchive extends BaseArchive
{
    abstract protected function _loadNVP(NVP $value);
    abstract protected function _loadSizeTag(SizeTag $value);
    abstract protected function _loadIntegral(Integral $value);
    abstract protected function _loadStr(Str $value);
    abstract protected function _loadBinary(Binary $value);

    public function load(Serializable $value)
    {
        if ($value instanceof NVP)
        {
            $this->_loadNVP($value);
        }
        elseif ($value instanceof SizeTag)
        {
            $this->_loadSizeTag($value);
        }
        elseif ($value instanceof Integral)
        {
            $this->_loadIntegral($value);
        }
        elseif ($value instanceof Str)
        {
            $this->_loadStr($value);
        }
        elseif ($value instanceof Binary)
        {
            $this->_loadBinary($value);
        }
        else
        {
            $value->load($this);
        }
    }

    public function __invoke(Serializable $value)
    {
        $this->load($value);
    }
}

?>
