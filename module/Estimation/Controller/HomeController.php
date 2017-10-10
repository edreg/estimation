<?php
/**
 * Class HomeController
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 10/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Controller;

use Estimation\Service\EstimationService;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

class HomeController extends AbstractController
{

    private $estimationService;

    const INDEX_TWIG = 'index.twig';

    const LAYOUT_TWIG = 'layout.twig';

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->estimationService = new EstimationService();
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction($request, $response, $args) : ResponseInterface
    {
        unset($request);
        $this->logger->info("Slim-Skeleton '/' route");

        $args['content'] = HomeController::INDEX_TWIG;
        $args['jsFileList']  = $this->estimationService->getJsFileList();
        $args['cssFileList'] = $this->estimationService->getCssFileList();

        return $this->view->render($response, HomeController::LAYOUT_TWIG, $args);
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function calculateAction($request, $response, $args) : ResponseInterface
    {
        try
        {
            $args = $this->estimationService->getViewArguments($request, $args);

            return $this->view->render($response, HomeController::LAYOUT_TWIG, $args);
        }
        catch(\Exception $exception)
        {
            $args['error'] = $exception->getMessage();
            $args['content'] = HomeController::INDEX_TWIG;
            $this->logger->error($exception->getMessage());

            return $this->view->render($response, HomeController::LAYOUT_TWIG, $args);
        }
        catch(\Error $error)
        {
            $args['error'] = $error->getMessage();
            $args['content'] = HomeController::INDEX_TWIG;
            $this->logger->crit($error->getMessage());

            return $this->view->render($response, HomeController::LAYOUT_TWIG, $args);
        }
    }
}