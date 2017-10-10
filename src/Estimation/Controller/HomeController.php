<?php
/**
 * Class HomeController
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Controller;

use Estimation\Helper\EstimationHelper;
use Estimation\Model\EstimationModel;

class HomeController extends AbstractController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction($request, $response, $args)
    {
        $this->logger->info("Slim-Skeleton '/' route");

        $args['content'] = 'index.twig';

        return $this->view->render($response, 'layout.twig', $args);
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function calculateAction($request, $response, $args)
    {
        $this->logger->info("Slim-Skeleton '/' post route");

        try
        {
            $estimationModel = new EstimationModel();
            $estimationModel->initFromRequest($request);

            $estimationHelper = new EstimationHelper($estimationModel);
            $estimationHelper->calculate();

            $args['threeP']      = number_format($estimationHelper->getThreePoint(), 2);
            $args['average']     = number_format($estimationHelper->getAverage(), 2);
            $args['pert']        = number_format($estimationHelper->getPert(), 2);
            $args['optimistic']  = $estimationModel->getOptimisticEstimation();
            $args['realistic']   = $estimationModel->getRealisticEstimation();
            $args['pessimistic'] = $estimationModel->getPessimisticEstimation();
            $args['probability'] = $estimationModel->getProbability();
            $args['uncertainty'] = $estimationModel->getUncertainty();
            $args['content']     = 'calculation-result.twig';

            return $this->view->render($response, 'layout.twig', $args);
        }
        catch(\Exception $exception)
        {
            $args['error'] = $exception->getMessage();
            $args['content'] = 'index.twig';

            return $this->view->render($response, 'layout.twig', $args);
        }
        catch(\Error $error)
        {
            $args['error'] = $error->getMessage();
            $args['content'] = 'index.twig';

            return $this->view->render($response, 'layout.twig', $args);
        }
    }
}