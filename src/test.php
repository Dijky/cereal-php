<?php declare(strict_types=1);

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");

$autoloader = require '../vendor/autoload.php';

use \Dijky\Cereal\Serializable;

use \Dijky\Cereal\Traits\SerializeShortcut;

use \Dijky\Cereal\Archives\BaseArchive;
use \Dijky\Cereal\Archives\PhpInputArchive;
use \Dijky\Cereal\Archives\PhpOutputArchive;
use \Dijky\Cereal\Archives\StringBinaryInputArchive;
use \Dijky\Cereal\Archives\StringPortableBinaryInputArchive;
use \Dijky\Cereal\Archives\StreamBinaryInputArchive;
use \Dijky\Cereal\Archives\StreamPortableBinaryInputArchive;
use \Dijky\Cereal\Archives\StringBinaryOutputArchive;
use \Dijky\Cereal\Archives\StringPortableBinaryOutputArchive;
use \Dijky\Cereal\Archives\StreamBinaryOutputArchive;
use \Dijky\Cereal\Archives\StreamPortableBinaryOutputArchive;

use \Dijky\Cereal\Types\Str;
use \Dijky\Cereal\Types\Integral;
use \Dijky\Cereal\Types\Vector;
use \Dijky\Cereal\Types\FixedArray;
use \Dijky\Cereal\Types\Binary;
use \Dijky\Cereal\Util\BinaryPacker;

class TestClass implements Serializable
{
    private $d;
    private $ui32;
    private $s;
    private $b;
    private $data;
    private $array;

    public function __construct($d = null, int $ui32 = null, string $s = null, bool $b = false, string $data = null)
    {
        $this->d = $d;
        $this->ui32 = $ui32;
        $this->s = $s;
        $this->b = $b;
        $this->data = $data;
        $this->vec = [
            Integral\UInt8::make(0xDE),
            Integral\UInt8::make(0xAD),
            Integral\UInt8::make(0xBE),
            Integral\UInt8::make(0xEF)
        ];
    }

    use SerializeShortcut;
    public function serialize(BaseArchive $ar)
    {
//        $ar(new Integral\Double($this->d));
        $ar(new Integral\UInt32($this->ui32));
        $ar(new Str($this->s));
        $ar(new Integral\Boolean($this->b));
        if ($this->b)
            $ar(new Binary($this->data, 4));
        $ar(new Vector(Integral\UInt8::class, $this->vec));
    }
}

$data = fopen("php://memory", "rw");

$oar = null;
if (count($argv) > 1)
{
    if ($argv[1] === "b")
        $oar = new StreamBinaryOutputArchive($data);
    elseif ($argv[1] === "b+")
        $oar = new StreamBinaryOutputArchive($data, BinaryPacker::BigEndian);
    elseif ($argv[1] === "b-")
        $oar = new StreamBinaryOutputArchive($data, BinaryPacker::LittleEndian);
    elseif ($argv[1] === "p")
        $oar = new StreamPortableBinaryOutputArchive($data);
    elseif ($argv[1] === "p+")
        $oar = new StreamPortableBinaryOutputArchive($data, BinaryPacker::BigEndian);
    elseif ($argv[1] === "p-")
        $oar = new StreamPortableBinaryOutputArchive($data, BinaryPacker::LittleEndian);
}
else
{
    $oar = new PhpOutputArchive();
}

$oaclass = get_class($oar);
fprintf(STDERR, ">> Using $oaclass\n");


$obj = new TestClass(0.5, 0xDEADBEEF, "Hello World", true, hex2bin("BAADF00D"));
$oar($obj);
rewind($data);
stream_copy_to_stream($data, STDOUT);
rewind($data);


$iar = null;
if (count($argv) > 2)
{
    if ($argv[2] === "b")
        $iar = new StreamBinaryInputArchive($data);
    elseif ($argv[2] === "b+")
        $iar = new StreamBinaryInputArchive($data, BinaryPacker::BigEndian);
    elseif ($argv[2] === "b-")
        $iar = new StreamBinaryInputArchive($data, BinaryPacker::LittleEndian);
    elseif ($argv[2] === "p")
        $iar = new StreamPortableBinaryInputArchive($data);
    elseif ($argv[2] === "p+")
        $iar = new StreamPortableBinaryInputArchive($data, BinaryPacker::BigEndian);
    elseif ($argv[2] === "p-")
        $iar = new StreamPortableBinaryInputArchive($data, BinaryPacker::LittleEndian);
}
else
{
    $iar = new PhpInputArchive();
}

$obj2 = new TestClass();
$iar($obj2);

flush();
//fprintf(STDERR, print_r($obj2, true));

// echo $data;

/*
$ar = new PhpOutputArchive();

$oar = new PhpOutputArchive();
$oar($obj);
$res = $oar->result();

echo $res . "\n\n";


$iar = new PhpInputArchive($res);
$o = new TestClass();

$iar($o);

var_dump($o);
*/
