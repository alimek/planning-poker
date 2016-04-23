<?php

namespace AppBundle\Util;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

class SingularizeInflector implements InflectorInterface
{
    public function pluralize($word)
    {
        return $word;
    }
}
