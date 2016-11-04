<?php

class Mutator
{
    public static function constant(Individual $child)
    {
        $mutatedChild = new Individual();
        $mutatedChildValues = [];
        $arrayIndex = 0;
        foreach($child->getValues() as $value) {
            if(rand(0,1) == 0) {
                $mutatedChildValues[$arrayIndex] = $value + Evolutor::$valueMutation;
            } else {
                $mutatedChildValues[$arrayIndex] = $value - Evolutor::$valueMutation;
            }
            $arrayIndex++;
        }
        $mutatedChild->setValues($mutatedChildValues);
        return $mutatedChild;
    }
}
