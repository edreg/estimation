<?php
/**
 * Class EstimationModel
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Model;

use Slim\Http\Request;

class EstimationModel
{
    /** @var float */
    public $optimisticEstimation;

    /** @var float */
    public $realisticEstimation;

    /** @var float */
    public $pessimisticEstimation;

    /** @var float */
    public $probability;

    /** @var float */
    public $uncertainty;

    /** @var float */
    public $threePoint;

    /** @var float */
    public $average;

    /** @var float */
    public $pert;

    /**
     * @return float
     */
    public function getOptimisticEstimation() : float
    {
        return $this->optimisticEstimation;
    }

    /**
     * @param float $optimisticEstimation
     */
    public function setOptimisticEstimation(float $optimisticEstimation)
    {
        $this->optimisticEstimation = $optimisticEstimation;
    }

    /**
     * @return float
     */
    public function getRealisticEstimation() : float
    {
        return $this->realisticEstimation;
    }

    /**
     * @param float $realisticEstimation
     */
    public function setRealisticEstimation(float $realisticEstimation)
    {
        $this->realisticEstimation = $realisticEstimation;
    }

    /**
     * @return float
     */
    public function getPessimisticEstimation() : float
    {
        return $this->pessimisticEstimation;
    }

    /**
     * @param float $pessimisticEstimation
     */
    public function setPessimisticEstimation(float $pessimisticEstimation)
    {
        $this->pessimisticEstimation = $pessimisticEstimation;
    }

    /**
     * @return float
     */
    public function getProbability() : float
    {
        return $this->probability;
    }

    /**
     * @param float $probability
     */
    public function setProbability(float $probability)
    {
        $this->probability = $probability;
    }

    /**
     * @return float
     */
    public function getUncertainty() : float
    {
        return $this->uncertainty;
    }

    /**
     * @param float $uncertainty
     */
    public function setUncertainty(float $uncertainty)
    {
        $this->uncertainty = $uncertainty;
    }

    /**
     * @return float
     */
    public function getThreePoint() : float
    {
        return $this->threePoint;
    }

    /**
     * @param float $threePoint
     */
    public function setThreePoint(float $threePoint)
    {
        $this->threePoint = number_format($threePoint, 2);
    }

    /**
     * @return float
     */
    public function getAverage() : float
    {
        return $this->average;
    }

    /**
     * @param float $average
     */
    public function setAverage(float $average)
    {
        $this->average = number_format($average, 2);
    }

    /**
     * @return float
     */
    public function getPert() : float
    {
        return $this->pert;
    }

    /**
     * @param float $pert
     */
    public function setPert(float $pert)
    {
        $this->pert = number_format($pert, 2);
    }

    /**
     * @param \Slim\Http\Request $request
     */
    public function initFromRequest(Request $request)
    {
        $this->setOptimisticEstimation((float) $request->getParam('optimistic'));
        $this->setRealisticEstimation((float) $request->getParam('realistic'));
        $this->setUncertainty((float) $request->getParam('uncertainty'));
        $this->setProbability((float) $request->getParam('probability'));
        $this->setPessimisticEstimation($this->realisticEstimation * $this->uncertainty);
    }


}