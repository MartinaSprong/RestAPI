<?php

/**
 * Created by PhpStorm.
 * User: martinasprong
 * Date: 04-04-16
 * Time: 10:57
 */

use Symfony\Component\Form\FormFactoryInterface;

class PageHandler implements PageHandlerInterface
{
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    // ...
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new Page.
     *
     * @param array $parameters
     *
     * @return PageInterface
     */
    public function post(array $parameters)
    {
        $page = $this->createPage(); // factory method create an empty Page

        // Process form does all the magic, validate and hydrate the Page Object.
        return $this->processForm($page, $parameters, 'POST');
    }

    /**
     * Create a Page from the submitted data.
     *
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
}