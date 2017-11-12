<?php declare(strict_types=1);

namespace Dijky\Cereal\Types;

use \Traversable;
use \InvalidArgumentException;
use \Dijky\Cereal\Serializable;

use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;

class FixedArray implements Serializable
{
    private $store;

    public function __construct(string $type, array &$store)
    {
        $this->store =& $store;
    }
    public static function make($type, $count) : FixedArray
    {
        $store = [];
        for ($i = 0; $i < $count; $i++)
        {
            $store[$i] = new $type();
        }
        return new self($type, $store);
    }

    public function load(BaseInputArchive $ar)
    {
        foreach($this->store as $i => &$v)
        {
            if (!($v instanceof Serializable))
            {
                throw new InvalidArgumentException("Element '$i' is not Serializable");
            }
            $ar($v);
        }
    }

    public function save(BaseOutputArchive $ar)
    {
        foreach($this->store as $i => &$v)
        {
            if (!($v instanceof Serializable))
            {
                throw new InvalidArgumentException("Element '$i' is not Serializable");
            }
            $ar($v);
        }
    }

    public function &value()
    {
        return $this->store;
    }

    public function size() : int
    {
        return count($this->store);
    }
}
