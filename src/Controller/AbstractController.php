<?php
/**
 * Class AbstractController
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 09/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Controller;

use Estimation\Exception\ControllerConstructException;
use Monolog\Logger;
use Slim\Container;
use Slim\Views\Twig;
use Estimation\Helper\Response;

class AbstractController
{
    /** @var Twig */
    protected $view;

    /** @var Container */
    protected $container;

    /** @var Logger */
    protected $logger;

    /** @var Response */
    protected $response;

    public function __construct(Container $container)
    {
        if (!($container['view'] instanceof Twig))
        {
            throw new ControllerConstructException('container[view] is not instance of Twig');
        }

        if (!($container['logger'] instanceof Logger))
        {
            throw new ControllerConstructException('container[logger] is not instance of Logger');
        }

        if (!($container['response'] instanceof Response))
        {
            throw new ControllerConstructException('container[response] is not instance of Response');
        }

        $this->container = $container;
        $this->view      = $this->container['view'];
        $this->logger    = $this->container['logger'];
        $this->response  = $this->container['response'];
    }

}
