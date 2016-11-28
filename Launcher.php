<?php

require_once "Individual.php";
require_once "FitnessCalculator.php";
require_once "EnvironmentSelector.php";
require_once "Recombinator.php";
require_once "Mutator.php";
require_once "Evolutor.php";

$configGenDepLin = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependent',
    'recombinator' => 'random',
    'environmentSelector' => 'roulette'
];

$configGenDepExp = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependentExponential',
    'recombinator' => 'random',
    'environmentSelector' => 'roulette'
];

$configConstant = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'constant',
    'recombinator' => 'random',
    'environmentSelector' => 'roulette'
];

$configGenDepLinBF = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependent',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness'
];

$configGenDepExpBF = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'generationDependentExponential',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness'
];

$configConstantBF = [
    'fitnessCalculator' => 'griewank',
    'mutator' => 'constant',
    'recombinator' => 'random',
    'environmentSelector' => 'bestFitness',
];

var_dump('start');

$evGenDepLin = new Evolutor($configGenDepLin);
$evGenDepExp = new Evolutor($configGenDepExp);
$evConstant = new Evolutor($configConstant);
$evGenDepLinBF = new Evolutor($configGenDepLinBF);
$evGenDepExpBF = new Evolutor($configGenDepExpBF);
$evConstantBF = new Evolutor($configConstantBF);

$cols = [
    ['id' => "", 'label' => '', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'constant mutation | roulette selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation (lin) | roulette selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation (exp) | roulette selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'constant mutation | best fitness selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation (lin) | best fitness selection', 'pattern' => '', 'type' => 'number'],
    ['id' => "", 'label' => 'generation dependent mutation (exp) | best fitness selection', 'pattern' => '', 'type' => 'number'],
];

$minValConstantMutation = 1000;
$minValGenDepLinMutation = 1000;
$minValGenDepExpMutation = 1000;
$minValConstantMutationBF = 1000;
$minValGenDepLinMutationBF = 1000;
$minValGenDepExpMutationBF = 1000;

$maxValConstantMutation = 0;
$maxValGenDepLinMutation = 0;
$maxValGenDepExpMutation = 0;
$maxValConstantMutationBF = 0;
$maxValGenDepLinMutationBF = 0;
$maxValGenDepExpMutationBF = 0;

$averageValConstantMutation = 0;
$averageValGenDepLinMutation = 0;
$averageValGenDepExpMutation = 0;
$averageValConstantMutationBF = 0;
$averageValGenDepLinMutationBF = 0;
$averageValGenDepExpMutationBF = 0;

$rows = [];

for ($i = 1; $i <= 50; $i++) {
    $valueConstantMutation = $evConstant->startEvolution()->getFitness();
    $valueGenDepLinMutation = $evGenDepLin->startEvolution()->getFitness();
    $valueGenDepExpMutation = $evGenDepExp->startEvolution()->getFitness();
    $valueConstantMutationBF = $evConstantBF->startEvolution()->getFitness();
    $valueGenDepLinMutationBF = $evGenDepLinBF->startEvolution()->getFitness();
    $valueGenDepExpMutationBF = $evGenDepExpBF->startEvolution()->getFitness();

    $minValConstantMutation = ($valueConstantMutation < $minValConstantMutation) ? $valueConstantMutation : $minValConstantMutation;
    $minValGenDepLinMutation = ($valueGenDepLinMutation < $minValGenDepLinMutation) ? $valueGenDepLinMutation : $minValGenDepLinMutation;
    $minValGenDepExpMutation = ($valueGenDepExpMutation < $minValGenDepExpMutation) ? $valueGenDepExpMutation : $minValGenDepExpMutation;
    $minValConstantMutationBF = ($valueConstantMutationBF < $minValConstantMutationBF) ? $valueConstantMutationBF : $minValConstantMutationBF;
    $minValGenDepLinMutationBF = ($valueGenDepLinMutationBF < $minValGenDepLinMutationBF) ? $valueGenDepLinMutationBF : $minValGenDepLinMutationBF;
    $minValGenDepExpMutationBF = ($valueGenDepExpMutationBF < $minValGenDepExpMutationBF) ? $valueGenDepExpMutationBF : $minValGenDepExpMutationBF;

    $maxValConstantMutation = ($valueConstantMutation > $maxValConstantMutation) ? $valueConstantMutation : $maxValConstantMutation;
    $maxValGenDepLinMutation = ($valueGenDepLinMutation > $maxValGenDepLinMutation) ? $valueGenDepLinMutation : $maxValGenDepLinMutation;
    $maxValGenDepExpMutation = ($valueGenDepExpMutation > $maxValGenDepExpMutation) ? $valueGenDepExpMutation : $maxValGenDepExpMutation;
    $maxValConstantMutationBF = ($valueConstantMutationBF > $maxValConstantMutationBF) ? $valueConstantMutationBF : $maxValConstantMutationBF;
    $maxValGenDepLinMutationBF = ($valueGenDepLinMutationBF > $maxValGenDepLinMutationBF) ? $valueGenDepLinMutationBF : $maxValGenDepLinMutationBF;
    $maxValGenDepExpMutationBF = ($valueGenDepExpMutationBF > $maxValGenDepExpMutationBF) ? $valueGenDepExpMutationBF : $maxValGenDepExpMutationBF;

    $averageValConstantMutation += $valueConstantMutation;
    $averageValGenDepLinMutation += $valueGenDepLinMutation;
    $averageValGenDepExpMutation += $valueGenDepExpMutation;
    $averageValConstantMutationBF += $valueConstantMutationBF;
    $averageValGenDepLinMutationBF += $valueGenDepLinMutationBF;
    $averageValGenDepExpMutationBF += $valueGenDepExpMutationBF;

    $rows[] = [
        'c' => [
            ["v" => $i, "f" => null],
            ["v" => $valueConstantMutation, "f" => null],
            ["v" => $valueGenDepLinMutation, "f" => null],
            ["v" => $valueGenDepExpMutation, "f" => null],
            ["v" => $valueConstantMutationBF, "f" => null],
            ["v" => $valueGenDepLinMutationBF, "f" => null],
            ["v" => $valueGenDepExpMutationBF, "f" => null],
        ]
    ];
}

$averageValConstantMutation /= 50;
$averageValGenDepLinMutation /= 50;
$averageValGenDepExpMutation /= 50;
$averageValConstantMutationBF /= 50;
$averageValGenDepLinMutationBF /= 50;
$averageValGenDepExpMutationBF /= 50;

echo '<br/>';
echo 'min/max/average constant mutation / roulette<br/>';
echo $minValConstantMutation . ' / '. $maxValConstantMutation . ' / '. $averageValConstantMutation .'<br/>';
echo 'min/max/average gen dep linear mutation / roulette<br/>';
echo $minValGenDepLinMutation . ' / '. $maxValGenDepLinMutation . ' / '. $averageValGenDepLinMutation .'<br/>';
echo 'min/max/average gen dep exponential mutation / roulette<br/>';
echo $minValGenDepExpMutation . ' / '. $maxValGenDepExpMutation . ' / '. $averageValGenDepExpMutation .'<br/>';
echo 'min/max/average constant mutation / best fitness<br/>';
echo $minValConstantMutationBF . ' / '. $maxValConstantMutationBF . ' / '. $averageValConstantMutationBF .'<br/>';
echo 'min/max/average gen dep linear mutation / best fitness<br/>';
echo $minValGenDepLinMutationBF . ' / '. $maxValGenDepLinMutationBF . ' / '. $averageValGenDepLinMutationBF .'<br/>';
echo 'min/max/average gen dep exponential mutation / best fitness<br/>';
echo $minValGenDepExpMutationBF . ' / '. $maxValGenDepExpMutationBF . ' / '. $averageValGenDepExpMutationBF .'<br/>';
echo '<br/>';

$arr_data = ['cols' => $cols, 'rows' => $rows];
$myFile = "data/data".time().".json";
$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
try {
    file_put_contents($myFile, $jsondata);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
var_dump('success');