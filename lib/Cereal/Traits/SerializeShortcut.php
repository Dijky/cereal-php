<?php declare(strict_types=1);

namespace Dijky\Cereal\Traits;

use \Dijky\Cereal\Archives\BaseArchive;
use \Dijky\Cereal\Archives\BaseInputArchive;
use \Dijky\Cereal\Archives\BaseOutputArchive;

trait SerializeShortcut
{
    public function load(BaseInputArchive $ar)
    {
        $this->serialize($ar);
    }

    public function save(BaseOutputArchive $ar)
    {
        $this->serialize($ar);
    }
}
