<?php declare(strict_types=1);

namespace Dijky\Cereal;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;
use \Exception;

class SizeTag implements Serializable
{
    private $size;

    public function __construct(int &$size)
    {
        $this->size =& $size;
    }

    public static function make(int $size = 0) : SizeTag
    {
        return new self($size);
    }

    public function load(BaseInputArchive $ar)
    {
        throw new Exception("SizeTag load needs to be implemented by InputArchive");
    }

    public function save(BaseOutputArchive $ar)
    {
        throw new Exception("SizeTag save needs to be implemented by OutputArchive");
    }

    public function &size() : int
    {
        return $this->size;
    }
}
