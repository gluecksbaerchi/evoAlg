<?php

class FitnessCalculator
{
    /**
     * @param Individual $individual
     * @return number
     */
    public static function functionA(Individual $individual)
    {
        $values = $individual->getValues();
        $fitness = (pow(($values[0] + 10*$values[1]), 2) + 5*pow(($values[2] - $values[3]), 2)
            + pow(($values[1] - 2*$values[2]), 4) + 10* pow(($values[0] - $values[3]), 4));

        return $fitness;
    }
}
