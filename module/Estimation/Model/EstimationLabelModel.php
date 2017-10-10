<?php
/**
 * Class EstimationLabelModel
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Model;

class EstimationLabelModel
{
    /** @var string */
    public $optimisticEstimation = 'Optimistic';

    /** @var string */
    public $realisticEstimation = 'Realistic';

    /** @var string */
    public $pessimisticEstimation = 'Pessimistic';

    /** @var string */
    public $probability = 'Probability';

    /** @var string */
    public $uncertainty = 'Uncertainty';

    /** @var string */
    public $threePoint = '3P';

    /** @var string */
    public $average = 'Average';

    /** @var string */
    public $pert = 'Pert';
}