<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 11:47
 */

require_once "Launcher.php";
require_once "Individual.php";

class EnvironmentSelector
{
    /**
     * @param Individual[] $parents
     * @param Individual[] $children
     * @return Individual[]
     */
    public static function bestFitness($parents, $children)
    {
        $compare = function(Individual $a, Individual $b) {
            if($a->getFitness() == $b->getFitness()) {
                return 0;
            }
            return ($a->getFitness() < $b->getFitness()) ? -1 : 1;
        };

        $combined = array_merge($parents, $children);
        usort($combined, $compare);
        return array_slice($combined, 0, Launcher::$amountSurvivingIndividuals);
    }

    // Todo: other selection functions (roulette, turnament)
}
