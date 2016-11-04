<?php

/**
 * Created by PhpStorm.
 * User: Carolin
 * Date: 04.11.2016
 * Time: 11:33
 */
class Individual
{
    /**
     * @var array
     */
    private $values = [];

    /**
     * @var double
     */
    private $fitness;

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return double
     */
    public function getFitness()
    {
        return $this->fitness;
    }

    /**
     * @param double $fitness
     */
    public function setFitness($fitness)
    {
        $this->fitness = $fitness;
    }
}