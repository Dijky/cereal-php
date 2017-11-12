<?php declare(strict_types=1);

namespace Dijky\Cereal\Archives;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\NVP;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Binary;

abstract class BaseOutputArchive extends BaseArchive
{
    abstract protected function _saveNVP(NVP $value);
    abstract protected function _saveSizeTag(SizeTag $value);
    abstract protected function _saveIntegral(Integral $value);
    abstract protected function _saveStr(Str $value);
    abstract protected function _saveBinary(Binary $value);

    public function save(Serializable $value)
    {
        if ($value instanceof NVP)
        {
            $this->_saveNVP($value);
        }
        elseif ($value instanceof SizeTag)
        {
            $this->_saveSizeTag($value);
        }
        elseif ($value instanceof Integral)
        {
            $this->_saveIntegral($value);
        }
        elseif ($value instanceof Str)
        {
            $this->_saveStr($value);
        }
        elseif ($value instanceof Binary)
        {
            $this->_saveBinary($value);
        }
        else
        {
            $value->save($this);
        }
    }

    public function __invoke(Serializable $value)
    {
        $this->save($value);
    }
}

?>
