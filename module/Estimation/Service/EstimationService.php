<?php
/**
 * Class EstimationService
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Service;

use Estimation\Helper\EstimationHelper;
use Estimation\Model\EstimationLabelModel;
use Estimation\Model\EstimationModel;
use Estimation\Model\EstimationSettingsModel;

class EstimationService
{
    /**
     * @param $request
     * @param $args
     *
     * @return mixed
     * @throws \Estimation\Exception\ValidationEstimationException
     */
    public function getViewArguments($request, $args)
    {
        $estimationModel = new EstimationModel();
        $estimationModel->initFromRequest($request);

        $estimationHelper = new EstimationHelper($estimationModel);
        $estimationHelper->calculate();

        $args['optimistic']  = $estimationModel->getOptimisticEstimation();
        $args['realistic']   = $estimationModel->getRealisticEstimation();
        $args['pessimistic'] = $estimationModel->getPessimisticEstimation();
        $args['probability'] = $estimationModel->getProbability();
        $args['uncertainty'] = $estimationModel->getUncertainty();
        $args['threeP']      = $estimationModel->getThreePoint();
        $args['average']     = $estimationModel->getAverage();
        $args['pert']        = $estimationModel->getPert();

        $settingsModel                   = new EstimationSettingsModel();
        $settingsModel->dataTableId      = 'estimation-table';
        $settingsModel->dataList         = $estimationHelper->getCalculationList();
        $settingsModel->columnList       = new EstimationLabelModel();
        $settingsModel->tableFilterValue = '';

        $args['settings']    = 'estimation-settings';
        $args['dataTableId'] = $settingsModel->dataTableId;
        $args['settingList'] = json_encode($settingsModel, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP);
        $args['jsFileList']  = $this->getJsFileList();
        $args['cssFileList'] = $this->getCssFileList();

        $args['content'] = 'calculation-result.twig';

        return $args;
    }

    /**
     * @return mixed
     */
    public function getCssFileList()
    {
        return [
            'components/bootstrap/dist/css/bootstrap.css',
            'components/datatables/media/css/dataTables.bootstrap.css',
            'module/Estimation/assets/css/estimation.css',
        ];
    }

    /**
     * @return mixed
     */
    public function getJsFileList()
    {
        return [
            'components/jquery/dist/jquery.js',
            'components/bootstrap/dist/js/bootstrap.js',
            'components/bootstrap/js/button.js',
            'components/datatables/media/js/jquery.dataTables.js',
            'components/datatables/media/js/dataTables.bootstrap.js',
            'components/datatables-rowsgroup/dataTables.rowsGroup.js',
            'components/system.js/dist/system.src.js',
            'module/Estimation/assets/js/estimation.js',
        ];
    }
}