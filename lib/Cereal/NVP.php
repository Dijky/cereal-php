<?php declare(strict_types=1);

namespace Dijky\Cereal;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;
use \Exception;

class NVP implements Serializable;
{
    private $name;
    private $value;

    public function __construct(string &$name, Serializable &$value)
    {
        $this->name =& $name;
        $this->value =& $value;
    }

    public static function make(string $name = "", Serializable &$value = null)
    {
        return new self($name, $value);
    }

    public function load(BaseInputArchive $ar)
    {
        throw new Exception("NVP load needs to be implemented by InputArchive");
    }

    public function save(BaseOutputArchive $ar)
    {
        throw new Exception("NVP save needs to be implemented by OutputArchive");
    }

    public function &name() : string
    {
        return $this->name;
    }

    public function &value() : Serializable
    {
        return $this->value;
    }
}
