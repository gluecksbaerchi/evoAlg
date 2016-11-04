<?php

require_once "Individual.php";

class Mutator
{
    public static function constant(Individual $child)
    {
        $mutatedChild = new Individual();
        $mutatedChildValues = [];
        $arrayIndex = 0;
        foreach($child->getValues() as $value) {
            $mutatedChildValues[$arrayIndex] = $value + Launcher::$valueMutation;
            $arrayIndex++;
        }
        $mutatedChild->setValues($mutatedChildValues);
        return $mutatedChild;
    }
}
