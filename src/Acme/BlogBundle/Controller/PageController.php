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
     * Create a Page from the submitted data.
     *
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new page from the submitted data.",
     *   input = "Acme\BlogBundle\Form\PageType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @Annotations\View(
     *  template = "AcmeBlogBundle:Page:newPage.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postPageAction(Request $request)
    {
        try {
            // Hey Page handler create a new Page.
            $newPage = $this->container->get('acme_blog.page.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newPage->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_page', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
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

    /**
     * Presents the form to use to create a new page.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @return FormTypeInterface
     */
    public function newPageAction()
    {
        return $this->createForm(new PageType());
    }

}