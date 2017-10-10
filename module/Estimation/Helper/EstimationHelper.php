<?php
/**
 * Class EstimationHelper
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Helper;

use Estimation\Exception\ValidationEstimationException;
use Estimation\Model\EstimationModel;

class EstimationHelper
{
    /** @var EstimationModel */
    private $estimationModel;

    /**
     * @param \Estimation\Model\EstimationModel $estimationModel
     */
    public function setEstimationModel(EstimationModel $estimationModel)
    {
        $this->estimationModel = $estimationModel;
    }

    /**
     * EstimationHelper constructor.
     *
     * @param \Estimation\Model\EstimationModel $model
     *
     * @throws \Estimation\Exception\ValidationEstimationException
     */
    public function __construct(EstimationModel $model)
    {
        $this->setEstimationModel($model);
    }

    /**
     * @return array
     */
    public function getCalculationList() : array
    {
        $list = [];
        $probabilityList = range(0.1, 1, 0.1);
        $uncertaintyList = range(1, 10);

        foreach ($probabilityList as $probability)
        {
            $this->estimationModel->setProbability($probability);

            foreach ($uncertaintyList as $uncertainty)
            {
                $this->estimationModel->setUncertainty($uncertainty);
                $this->calculate();

                $list[] = clone $this->estimationModel;
            }
        }

        return $list;
    }

    public function calculate()
    {
        $this->validateEstimationModel();

        $probability           = $this->estimationModel->getProbability();
        $uncertainty           = $this->estimationModel->getUncertainty();
        $optimisticEstimation  = $this->estimationModel->getOptimisticEstimation();
        $realisticEstimation   = $this->estimationModel->getRealisticEstimation();
        $pessimisticEstimation = $uncertainty * $realisticEstimation;
        $differenceRO          = $realisticEstimation - $optimisticEstimation;
        $differencePO          = $pessimisticEstimation - $optimisticEstimation;

        $this->estimationModel->setPessimisticEstimation($pessimisticEstimation);

        $this->estimationModel->setAverage(
            ($optimisticEstimation + $realisticEstimation + $pessimisticEstimation) / 3
        );

        $this->estimationModel->setPert(
            ($optimisticEstimation + 4 * $realisticEstimation + $pessimisticEstimation) / 6
        );

        if ($probability <= $differenceRO / $differencePO)
        {
            $this->estimationModel->setThreePoint(
                $optimisticEstimation + sqrt($probability * $differenceRO * $differencePO)
            );
        }
        else
        {
            $differencePR = $pessimisticEstimation - $realisticEstimation;

            $this->estimationModel->setThreePoint(
                $pessimisticEstimation
                - sqrt
                (
                    $pessimisticEstimation ** 2
                    - $probability * $differencePO * $differencePR
                    + $differenceRO * $differencePR
                    - 2 * $pessimisticEstimation * $realisticEstimation
                    + $realisticEstimation ** 2
                )
            );
        }
    }

    /**
     * @throws \Estimation\Exception\ValidationEstimationException
     */
    private function validateEstimationModel()
    {
        $probability           = $this->estimationModel->getProbability();
        $uncertainty           = $this->estimationModel->getUncertainty();
        $optimisticEstimation  = $this->estimationModel->getOptimisticEstimation();
        $realisticEstimation   = $this->estimationModel->getRealisticEstimation();
        $pessimisticEstimation = $uncertainty * $realisticEstimation;;

        if ($probability <= 0 || $probability > 1)
        {
            throw new ValidationEstimationException('Please choose a probability between 0 and 1');
        }

        if ($uncertainty < 1)
        {
            throw new ValidationEstimationException('Please choose a uncertainty bigger than 1');
        }

        if ($optimisticEstimation <= 0 || $realisticEstimation <= 0 || $pessimisticEstimation <= 0)
        {
            throw new ValidationEstimationException('Please choose estimations bigger than 0');
        }

        if ($optimisticEstimation > $realisticEstimation || $realisticEstimation > $pessimisticEstimation)
        {
            throw new ValidationEstimationException('Please choose estimations : optimistic < realistic < pessimistic');
        }
    }
}