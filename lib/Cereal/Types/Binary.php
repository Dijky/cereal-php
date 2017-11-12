<?php declare(strict_types=1);

namespace Dijky\Cereal\Types;

use \Dijky\Cereal\Serializable;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;
use \Dijky\Cereal\SizeTag;
use \Dijky\Cereal\Packable;
use \Exception;

class Binary implements Serializable, Packable
{
    private $value;
    private $length;

    public function __construct(string &$value = null, int $length)
    {
        self::resize($value, $length);
        $this->value =& $value;
        $this->length = $length;
    }

    public static function make(string $value, int $length) : Binary
    {
        return new self($value, $length);
    }

    public function load(BaseInputArchive $ar)
    {
        throw new Exception("Binary load needs to be implemented by InputArchive");
    }

    public function save(BaseOutputArchive $ar)
    {
        throw new Exception("Binary save needs to be implemented by OutputArchive");
    }

    public function &value()
    {
        return $this->value;
    }

    public function size() : int
    {
        return $this->length;
    }

    public static function resize(string &$value = null, int $length)
    {
        if ($value === null)
            $value = "";
        $value = str_pad(substr($value, 0, $length), $length, "\0", \STR_PAD_RIGHT);
    }
}
