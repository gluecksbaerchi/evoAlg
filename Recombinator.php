<?php

class Recombinator
{
    public static function random(Individual $parentA, Individual $parentB)
    {
        $child = new Individual();
        $values = [];
        $parentAValues = $parentA->getValues();
        $parentBValues = $parentB->getValues();
        for($i = 0; $i < count($parentAValues); $i++) {
            $values[$i] = Evolutor::random($parentAValues[$i], $parentBValues[$i]);
        }
        $child->setValues($values);
        return $child;
    }
}
