<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 13:28
 */
class Evolutor
{
    public $config;

    /**
     * @var array
     */
    public static $numberRangeInitialPopulation = ['min' => -512, 'max' => 511];

    /**
     * @var int
     */
    public static $amountStartIndividuals = 30;

    /**
     * @var int
     */
    public static $amountVariables = 15; // n = 5; 10; 15; 20; 25; 30; 40;...

    /**
     * @var int
     */
    public static $amountGenerations = 1000;

    /**
     * @var int
     */
    public static $amountIndividualsPerGeneration = 30;

    /**
     * @var int
     */
    public static $amountSurvivingIndividuals = 15;

    /**
     * in %
     * @var int
     */
    public static $probabilityRecombination = 33;

    /**
     * in %
     * @var int
     */
    public static $probabilityMutation = 10;

    /**
     * @var int
     */
    public static $valueMutation = 5;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function startEvolution()
    {
        $tmp = $this->initiateIndividuals();
        foreach ($tmp as $individual) {
            $method = $this->config['fitnessCalculator'];
            /** @var Individual $individual */
            $individual->setFitness(FitnessCalculator::$method($individual));
        }

        for( $i = 1; $i <= self::$amountGenerations; $i++) {
            $pGen = $this->createGeneration($tmp, $i);
            $method = $this->config['environmentSelector'];
            $tmp = EnvironmentSelector::$method($tmp, $pGen);
        }
        $winner = $tmp[0];
        return $winner;
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

    public function createGeneration (array $individualList, int $generation) {

        $pGen = [];

        while(count($pGen) < self::$amountIndividualsPerGeneration) {

            //Selektion der Eltern
            do {
                $parentA = mt_rand(0,(count($individualList)-1));
                $parentB = mt_rand(0,(count($individualList)-1));
            } while ($parentA == $parentB);

            // Rekombination machen.. aber nur wenn $propabilityRecombination.
            if(mt_rand(0,100) <= self::$probabilityRecombination) {
                $method = $this->config['recombinator'];
                $child = Recombinator::$method($individualList[$parentA], $individualList[$parentB]);
                if(mt_rand(0,100) <= self::$probabilityMutation) {
                    $method = $this->config['mutator'];
                    /** @var Individual $child */
                    $child = Mutator::$method($child, $generation);
                }
                $method = $this->config['fitnessCalculator'];
                $child->setFitness(FitnessCalculator::$method($child));
                $pGen[] = $child;
            }
        }
        return $pGen;
    }
    
    public static function random($a, $b) 
    {
        $decimal = 6;
        if ($a < $b) {
            $min = $a * (10 ** $decimal);
            $max = $b * (10 ** $decimal);
        } else {
            $max = $a * (10 ** $decimal);
            $min = $b * (10 ** $decimal);
        }
        $number = mt_rand($min, $max) / (10**$decimal);
        return $number;
    }
}
