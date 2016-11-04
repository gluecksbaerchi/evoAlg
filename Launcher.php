<?php

$launcher = new Launcher();
$launcher->startAction();

class Launcher
{
    public function startAction()
    {

//      alles aus Formular rausholen

        $numberrangeInitalPopulation = ['min' => -10,
                                        'max' => 10];
        $amountStartIndividuals = 10;
        $amountVariables = 4;
        $amountGenerations = 2000;
        $amountIndividualsPerGeneration = 40;
        $amountSurvivingIndividuals = 10;
        // in %
        $propabilityRecombination = 33;
        // in %
        $propabilityMutation = 5;
        $valueMutation = 5;

        $individualList = $this->initiateAlgorithm($amountStartIndividuals,
                $amountVariables, $numberrangeInitalPopulation);

        $tmp = [];
        
        foreach ($individualList as $individual) {

            $individual['fitness'] = $this->applyFitnessfunction($individual);
            $tmp[] = $individual;
            //var_dump($individual);
            //echo '</br>';

        }
        
        //$tmp array for $individualList
        for( $i = 0; $i < $amountGenerations; $i++) {
            
            $pGen = $this->createGeneration($tmp, $amountIndividualsPerGeneration,
                    $amountSurvivingIndividuals, $propabilityRecombination,
                    $propabilityMutation, $valueMutation);

            $compare = function($a, $b) {
                if($a['fitness'] == $b['fitness']) {
                    return 0;
                }

                return ($a['fitness'] < $b['fitness']) ? -1 : 1;
            };

          //  echo 'Generation: ' . $i . '<br/>';
            $combined = array_merge($tmp, $pGen);
          //  var_dump($combined);
          //  echo '<br/>';
            //compare Fnktion um Fitness-Werte der Individuen zu vergleichen
            usort($combined, $compare);
          //  var_dump($combined);
          //  echo '<br/>';
            //unset($tmp);
            $tmp = array_slice($combined, 0, $amountSurvivingIndividuals);
            
        }
        
        $winner = $tmp[0];
        var_dump($winner);
       //$nextGeneration = [$amountIndividualsPerGeneration];


//        return $this->render('TimHelloBundle:Evo:start.html.twig', array(
//            // ...
//        ));
    }

    public function initiateAlgorithm(int $amountStartIndividuals,
            int $amountVariables, array $numberrangeInitalPopulation) {

        $individualList = [];

        for( $i = 0; $i < $amountStartIndividuals; $i++ ) {
 //         echo 'Individuum Nummer ' . ($i+1) . ' wird erzeugt...: </br>';
            $individual = $this->generateInitialIndividual($amountVariables,
                    $numberrangeInitalPopulation);
            $individualList[] = $individual;
        }

        //var_dump($individualList);

        return $individualList;
    }

    public function generateInitialIndividual(int $amountVariables,
            array $numberrangeInitialPopulation) {

        $individual = [];

        for($i = 0; $i < $amountVariables; $i++) {
            $valueRandom = rand($numberrangeInitialPopulation['min'],
                    $numberrangeInitialPopulation['max']);
//            echo $i . 'ter Durchlauf durch Zufallszahl-Schleife. Wert: '
//                    . $valueRandom . '</br>';
            $individual[($i+1)] = $valueRandom;
        }
//        echo '</br>';
        return $individual;

    }

    //$z ist das Individuum (name verkürzt wgen länge)

    public function applyFitnessfunction(array $z) {

//      Fitnessfunktion ist: y = (x_1 + 10x_2)^2 + 5(x3 - x4)^2 + (x2 - 2x3)^4 + 10(x1 - x4)^4

        $fitness = (pow(($z[1] + 10*$z[2]), 2) + 5*pow(($z[3] - $z[4]), 2) + pow(($z[2] - 2*$z[3]), 4) + 10* pow(($z[1] - $z[4]), 4));

        return $fitness;

    }

    public function createGeneration (array $individualList, int $amountIndividualsPerGeneration,
                int $amountSurvivingIndividuals, float $propabilityRecombination,
                float $propabilityMutation, int $valueMutation) {

        $pGen = [];

        while(count($pGen) < $amountIndividualsPerGeneration) {
            
            //Selektion der Eltern
            $parentA = rand(0,(count($individualList)-1));
            $parentB = rand(0,(count($individualList)-1));

            // Rekombination machen.. aber nur wenn $propabilityRecombination.
            if(rand(0,100) <= $propabilityRecombination) {
                $child = $this->recombination($individualList[$parentA], $individualList[$parentB]);
                if(rand(0,100) <= $propabilityMutation) {
                    $child = $this->mutation($child, $valueMutation);
                }
                $child['fitness'] = $this->applyFitnessfunction($child);
                $pGen[] = $child;
            }
        }
        return $pGen;
    }

    public function recombination(array $parentA, array $parentB) {

       // var_dump($parentA);
        $child = [];

        for($i = 1; $i < count($parentA); $i++) {

            //rand erlaubt auch rand(100,0) zB
            $child[$i] = rand($parentA[$i], $parentB[$i]);

           // echo $parentA[$i] . ' und ' . $parentB[$i] . ' = ' . $child[$i] . '<br/>';
        }

        return $child;

    }

    public function mutation(array $child, int $valueMutation) {

        $mutatedChild = [];
        $arrayIndex = 1;
        foreach($child as $value) {

            $mutatedChild[$arrayIndex] = $value + $valueMutation;
            $arrayIndex++;

        }

        return $mutatedChild;
    }
    
    public function compare ($a , $b) {
        
        if($a['fitness'] == $b['fitness']) {
            return 0;
        }
        
        return ($a['fitness'] < $b['fitness']) ? -1 : 1;
        
    }



}

