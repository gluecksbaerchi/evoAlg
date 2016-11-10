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
        return round($fitness, 6);
    }

    /**
     * @param Individual $individual
     * @return float
     */
    public static function griewank(Individual $individual)
    {
        $values = $individual->getValues();
        $resultPart1 = 1;
        $resultPart2 = 1;
        $n = count($values);
        for ($i = 0; $i < $n; $i++) {
            $resultPart1 += ($values[$i]**2) / (400*$n);
            $resultPart2 *= cos($values[$i] / sqrt($i+1));
        }
        return round($resultPart1 - $resultPart2, 6);
    }
}
