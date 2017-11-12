<?php declare(strict_types=1);

namespace Dijky\Cereal\Types;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;
use \Dijky\Cereal\SizeTag;
use \Exception;

class Str implements Serializable
{
    private $value;

    public function __construct(string &$value = null)
    {
        $this->value =& $value;
    }

    public static function make(string $value = null) : Str
    {
        return new self($value);
    }

    public function load(BaseInputArchive $ar)
    {
        throw new Exception("Str load needs to be implemented by InputArchive");
    }

    public function save(BaseOutputArchive $ar)
    {
        throw new Exception("Str save needs to be implemented by OutputArchive");
    }

    public function &value()
    {
        return $this->value;
    }

    public function size() : int
    {
        return $this->value !== null ? strlen($this->value) : 0;
    }
}
