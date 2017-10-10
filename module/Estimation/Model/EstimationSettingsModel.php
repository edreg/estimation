<?php
/**
 * Class EstimationSettingsModel
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Model;

class EstimationSettingsModel
{
    /** @var string */
    public $dataTableId;

    /** @var \Estimation\Model\EstimationModel */
    public $columnList;

    /** @var \Estimation\Model\EstimationModel */
    public $dataList;

    /** @var string */
    public $tableFilterValue;
}