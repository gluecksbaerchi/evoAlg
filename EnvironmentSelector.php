<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 11:47
 */

class EnvironmentSelector
{
     /**
     * @param Individual[] $parents
     * @param Individual[] $children
     * @return Individual[]
     */
    public function applyFitness($parents, $children) 
    {
        $compare = function(Individual $a, Individual $b) {
            if($a->getFitness() == $b->getFitness()) {
                return 0;
            }
            return ($a->getFitness() < $b->getFitness()) ? -1 : 1;
        };

        $combined = array_merge($parents, $children);
        return usort($combined, $compare);
    }
    
    
    /**
     * @param Individual[] $parents
     * @param Individual[] $children
     * @return Individual[]
     */
    public static function bestFitness($parents, $children)
    {
        $combined = $this->applyFitness($parents, $children);
        return array_slice($combined, 0, Evolutor::$amountSurvivingIndividuals);
    }

    // Todo: other selection functions (roulette, turnament)
    /**
     * @param Individual[] $parents
     * @param Individual[] $children
     * @return Individual[]
     */
    public static function roulette($parents, $children)
    {
        $combined = $this->applyFitness($parents, $children);        
        $tmp = [];
        for ( $i = 0; $i < Evolutor::$amountSurvivingIndividuals; $i++) {
            $rand = Evolutor::random(0, 1);
            $sum = 0;
            $tmpIndividual = $combined[0];
            foreach ($combined as $individual) {
                $length = count($combined);
                $sector = (2/$length)*(1-(($i-1)/($length-1)));     
                $sum += $sector;
                if ($sum <= $rand) {
                   $tmpIndividual = $individual; 
                } else {
                    $tmp[] = $tmpIndividual;
                    break;
                }
            }  
        }
        return $tmp;
    }
}
