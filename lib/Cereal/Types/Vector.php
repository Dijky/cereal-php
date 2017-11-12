<?php declare(strict_types=1);

namespace Dijky\Cereal\Types;

use \Exception;
use \Traversable;
use \InvalidArgumentException;
use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\DefaultConstructible;
use \Dijky\Cereal\SizeTag;

use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;

class Vector implements Serializable
{
    private $type;
    private $store;

    public function __construct(string $type, array &$store = null)
    {
        $this->type = $type;
        $this->store =& $store;
    }
    public static function make(string $type, array $store = []) : Vector
    {
        return new self($type, $store);
    }

    public function load(BaseInputArchive $ar)
    {
        $this->store = [];
        $type = $this->type;

        $size = 0;
        $ar(new SizeTag($size));

        for ($i = 0; $i < $size; $i++)
        {
            $this->store[$i] = new $type();
            $v =& $this->store[$i];
            $ar($v);
        }
    }

    public function save(BaseOutputArchive $ar)
    {
        $type = $this->type;
        $ar(SizeTag::make($this->size()));
        foreach($this->store as $v)
        {
            if (!is_a($v, Serializable::class))
            {
                $v = new $type($v);
                if (!is_a($v, Serializable::class))
                {
                    throw new Exception("Vector element of type '" . get_class($v) . "' is not Serializable");
                }
            }
            if (!is_a($v, DefaultConstructible::class))
            {
                throw new Exception("Vector element of type '" . get_class($v) . "' is not DefaultConstructible");
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
