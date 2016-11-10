<?php

class Mutator
{
    /**
     * @param Individual $child
     * @return Individual
     */
    public static function constant(Individual $child, int $generation)
    {
        return self::mutate($child, Evolutor::$valueMutation);
    }

    /**
     * @param Individual $child
     * @param int $generation
     * @return Individual
     */
    public static function generationDependent(Individual $child, int $generation)
    {
        $actualValueMutation = (($generation / Evolutor::$amountGenerations) * (-Evolutor::$valueMutation))
            + Evolutor::$valueMutation;
        return self::mutate($child, $actualValueMutation);
    }

    /**
     * @param Individual $child
     * @param $actualValueMutation
     * @return Individual
     */
    protected static function mutate(Individual $child, $actualValueMutation):Individual
    {
        $mutatedChild = new Individual();
        $mutatedChildValues = [];
        $arrayIndex = 0;
        foreach ($child->getValues() as $value) {
            if (rand(0, 1) == 0) {
                $mutatedChildValues[$arrayIndex] = $value + $actualValueMutation;
            } else {
                $mutatedChildValues[$arrayIndex] = $value - $actualValueMutation;
            }
            $arrayIndex++;
        }
        $mutatedChild->setValues($mutatedChildValues);
        return $mutatedChild;
    }
}
