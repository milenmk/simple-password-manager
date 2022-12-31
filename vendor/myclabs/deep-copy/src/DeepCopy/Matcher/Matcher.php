<?php

namespace DeepCopy\Matcher;

interface Matcher
{
    /**
     * @param object $object
     * @param string $property
     *
     * @return bool
     */
    public function matches($object, $property);
}
