<?php

require_once "Individual.php";
require_once "FitnessCalculator.php";
require_once "EnvironmentSelector.php";
require_once "Recombinator.php";
require_once "Mutator.php";
require_once "Evolutor.php";

$configGenDep = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependent',
    'recombinator' => 'random',
    'environmentSelector' => 'roulette'
];

$configConstant = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'constant',
    'recombinator' => 'random',
    'environmentSelector' => 'roulette'
];

$configGenDepBF = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependent',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness'
];

$configConstantBF = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'constant',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness',
];

//$launcher = new Evolutor($config);
//
//$result = 0;
//$count = 50;
//for ($i = 0; $i < $count; $i++) {
//    $result += $launcher->startEvolution()->getFitness();
//}
//var_dump($result/$count);

var_dump('start');

$evGenDep = new Evolutor($configGenDep);
$evConstant = new Evolutor($configConstant);
$evGenDepBF = new Evolutor($configGenDepBF);
$evConstantBF = new Evolutor($configConstantBF);

$cols = [
    ['id' => "", 'label' => '', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'constant mutation | roulette selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation | roulette selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation | best fitness selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation | best fitness selection', 'pattern' => '', 'type' => 'number'],
];

$rows = [];

for ($i = 1; $i <= 50; $i++) {
    $valueConstantMutation = $evConstant->startEvolution()->getFitness();
    $valueGenDepMutation = $evGenDep->startEvolution()->getFitness();
    $valueConstantMutationBF = $evConstantBF->startEvolution()->getFitness();
    $valueGenDepMutationBF = $evGenDepBF->startEvolution()->getFitness();

    $rows[] = [
        'c' => [
            ["v" => $i, "f" => null],
            ["v" => $valueConstantMutation, "f" => null],
            ["v" => $valueGenDepMutation, "f" => null],
            ["v" => $valueConstantMutationBF, "f" => null],
            ["v" => $valueGenDepMutationBF, "f" => null],
        ]
    ];
}

$arr_data = ['cols' => $cols, 'rows' => $rows];
$myFile = "data/data3.json";
$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
try {
    file_put_contents($myFile, $jsondata);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
var_dump('success');