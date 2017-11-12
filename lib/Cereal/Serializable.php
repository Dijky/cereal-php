<?php declare(strict_types=1);

namespace Dijky\Cereal;

use \Dijky\Cereal\Archives\BaseArchive;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;

interface Serializable
{
    public function load(BaseInputArchive $ar);
    public function save(BaseOutputArchive $ar);
}

?>
