<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 11:39
 */

require_once 'Individual.php';

class FitnessCalculator
{
    /**
     * @param Individual $individual
     * @return number
     */
    public static function functionA(Individual $individual)
    {
        $values = $individual->getValues();
        $fitness = (pow(($values[1] + 10*$values[2]), 2) + 5*pow(($values[3] - $values[4]), 2)
            + pow(($values[2] - 2*$values[3]), 4) + 10* pow(($values[1] - $values[4]), 4));

        return $fitness;
    }
}
