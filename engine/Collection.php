<?php

namespace Engine;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct($elements);
    }
}
