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
     * Get single Page,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Page for a given id",
     *   output = "Acme\BlogBundle\Entity\Page",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param Request $request the request object
     * @param int     $id      the page id
     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getPageAction($id)
    {
        $page = $this->container
            ->get('acme_blog.blog_post.handler')
            ->get($id);

        return $page;
    }

    /**
     * Fetch the Page or throw a 404 exception.
     *
     * @param mixed $id
     *
     * @return PageInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($page = $this->container->get('acme_blog.blog_post.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $page;
    }

}