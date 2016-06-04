<?php

namespace AppBundle\Util;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

class SingularizeInflector implements InflectorInterface
{
    /**
     * @param string $word
     * @return string
     */
    public function pluralize($word)
    {
        return $word;
    }
}
