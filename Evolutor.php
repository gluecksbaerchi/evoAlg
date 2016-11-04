<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 13:28
 */
class Evolutor
{
    /**
     * @var array
     */
    public static $numberRangeInitialPopulation = ['min' => -10, 'max' => 10];

    /**
     * @var int
     */
    public static $amountStartIndividuals = 10;

    /**
     * @var int
     */
    public static $amountVariables = 4;

    /**
     * @var int
     */
    public static $amountGenerations = 2000;

    /**
     * @var int
     */
    public static $amountIndividualsPerGeneration = 40;

    /**
     * @var int
     */
    public static $amountSurvivingIndividuals = 10;

    /**
     * in %
     * @var int
     */
    public static $probabilityRecombination = 33;

    /**
     * in %
     * @var int
     */
    public static $probabilityMutation = 5;

    /**
     * @var int
     */
    public static $valueMutation = 5;

    public function startEvolution()
    {

//      alles aus Formular rausholen

        $tmp = $this->initiateIndividuals();
        foreach ($tmp as $individual) {
            /** @var Individual $individual */
            $individual->setFitness(FitnessCalculator::functionA($individual));
        }

        for( $i = 0; $i < self::$amountGenerations; $i++) {
            $pGen = $this->createGeneration($tmp);
            $tmp = EnvironmentSelector::bestFitness($tmp, $pGen);
        }
        $winner = $tmp[0];
        var_dump($winner);
    }

    public function initiateIndividuals()
    {
        $individualList = [];

        for( $i = 0; $i < self::$amountStartIndividuals; $i++ ) {
            $individual = $this->generateInitialIndividual();
            $individualList[] = $individual;
        }

        return $individualList;
    }

    public function generateInitialIndividual()
    {
        $individual = new Individual();
        $individualValues = [];

        for($i = 0; $i < self::$amountVariables; $i++) {
            $valueRandom = self::random(self::$numberRangeInitialPopulation['min'],
                self::$numberRangeInitialPopulation['max']);
            $individualValues[$i] = $valueRandom;
        }
        $individual->setValues($individualValues);
        return $individual;
    }

    public function createGeneration (array $individualList) {

        $pGen = [];

        while(count($pGen) < self::$amountIndividualsPerGeneration) {

            //Selektion der Eltern
            $parentA = rand(0,(count($individualList)-1));
            $parentB = rand(0,(count($individualList)-1));

            // Rekombination machen.. aber nur wenn $propabilityRecombination.
            if(rand(0,100) <= self::$probabilityRecombination) {
                $child = Recombinator::random($individualList[$parentA], $individualList[$parentB]);
                if(rand(0,100) <= self::$probabilityMutation) {
                    $child = Mutator::constant($child);
                }
                $child->setFitness(FitnessCalculator::functionA($child));
                $pGen[] = $child;
            }
        }
        return $pGen;
    }
    
    public static function random($a, $b) 
    {        
        $decimal = 10;        
        $number = mt_rand($a*pow(10, $decimal), $b*pow(10, $decimal)) / pow(10, $decimal);        
        return $number;
    }
}
