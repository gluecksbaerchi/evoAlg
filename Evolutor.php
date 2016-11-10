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
    public static $amountGenerations = 500;

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
    public static $probabilityMutation = 10;

    /**
     * @var int
     */
    public static $valueMutation = 10;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function startEvolution()
    {

//      alles aus Formular rausholen

        $tmp = $this->initiateIndividuals();
        foreach ($tmp as $individual) {
            /** @var Individual $individual */
            $individual->setFitness(FitnessCalculator::functionA($individual));
        }

        for( $i = 1; $i <= self::$amountGenerations; $i++) {
            $pGen = $this->createGeneration($tmp, $i);
            $method = $this->config['environmentSelector'];
            $tmp = EnvironmentSelector::$method($tmp, $pGen);
        }
        $winner = $tmp[0];
        // var_dump($winner);
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
                $parentA = rand(0,(count($individualList)-1));
                $parentB = rand(0,(count($individualList)-1));
            } while ($parentA == $parentB);

            // Rekombination machen.. aber nur wenn $propabilityRecombination.
            if(rand(0,100) <= self::$probabilityRecombination) {
                $method = $this->config['recombinator'];
                $child = Recombinator::$method($individualList[$parentA], $individualList[$parentB]);
                if(rand(0,100) <= self::$probabilityMutation) {
                    $method = $this->config['mutator'];
                    $child = Mutator::$method($child, $generation);
                }
                $child->setFitness(FitnessCalculator::functionA($child));
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
        $number = rand($min, $max) / (10**$decimal);
        return $number;
    }
}
