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

    /** @var float */
    private $threePoint;

    /** @var float */
    private $average;

    /** @var float */
    private $pert;

    /**
     * @return float
     */
    public function getThreePoint() : float
    {
        return $this->threePoint;
    }

    /**
     * @return float
     */
    public function getAverage() : float
    {
        return $this->average;
    }

    /**
     * @return float
     */
    public function getPert() : float
    {
        return $this->pert;
    }

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
     */
    public function __construct(EstimationModel $model)
    {
        $this->setEstimationModel($model);
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

        $this->average = ($optimisticEstimation + $realisticEstimation + $pessimisticEstimation) / 3;
        $this->pert = ($optimisticEstimation + 4 * $realisticEstimation + $pessimisticEstimation) / 6;

        if ($probability <= $differenceRO / $differencePO)
        {
            $this->threePoint = $optimisticEstimation + sqrt($probability * $differenceRO * $differencePO);
        }
        else
        {
            $differencePR = $pessimisticEstimation - $realisticEstimation;

            $this->threePoint =
                $pessimisticEstimation
                - sqrt
                (
                    $pessimisticEstimation ** 2
                    - $probability * $differencePO * $differencePR
                    + $differenceRO * $differencePR
                    - 2 * $pessimisticEstimation * $realisticEstimation
                    + $realisticEstimation ** 2
                )
            ;
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