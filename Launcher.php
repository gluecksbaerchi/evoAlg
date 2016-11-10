<?php

require_once "Individual.php";
require_once "FitnessCalculator.php";
require_once "EnvironmentSelector.php";
require_once "Recombinator.php";
require_once "Mutator.php";
require_once "Evolutor.php";

$config = [
    //'mutator' => 'constant',
    'mutator' => 'generationDependent',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness'
];

$launcher = new Evolutor($config);

$result = 0;
for ($i = 0; $i < 10; $i++) {
    $result += $launcher->startEvolution()->getFitness();
}
var_dump($result/50);
