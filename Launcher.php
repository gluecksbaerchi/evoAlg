<?php

require_once "Individual.php";
require_once "FitnessCalculator.php";
require_once "EnvironmentSelector.php";
require_once "Recombinator.php";
require_once "Mutator.php";
require_once "Evolutor.php";

$launcher = new Evolutor();
$launcher->startEvolution();
