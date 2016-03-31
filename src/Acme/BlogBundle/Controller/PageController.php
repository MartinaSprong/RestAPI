<?php
/**
 * Created by PhpStorm.
 * User: martinasprong
 * Date: 31-03-16
 * Time: 11:54
 */

namespace Acme\BlogBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;

class PageController extends FOSRestController
{
    /**
     * @param $id
     * @return mixed
     */
    public function getPageAction($id)
    {
        return $this->container->get('doctrine.entity_manager')->getRepository('Page')->find($id);
    }

}