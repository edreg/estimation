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
    private $optimisticEstimation;

    /** @var float */
    private $realisticEstimation;

    /** @var float */
    private $pessimisticEstimation;

    /** @var float */
    private $probability;

    /** @var float */
    private $uncertainty;

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

    public function initFromRequest(Request $request)
    {
        $this->setOptimisticEstimation((float) $request->getParam('optimistic'));
        $this->setRealisticEstimation((float) $request->getParam('realistic'));
        $this->setUncertainty((float) $request->getParam('uncertainty'));
        $this->setProbability((float) $request->getParam('probability'));
        $this->setPessimisticEstimation($this->realisticEstimation * $this->uncertainty);
    }
}