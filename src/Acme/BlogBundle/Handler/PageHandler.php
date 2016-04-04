<?php

/**
 * Created by PhpStorm.
 * User: martinasprong
 * Date: 04-04-16
 * Time: 10:57
 */
class PageHandler implements PageHandlerInterface
{
    // ..
    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    // ...
    public function get($id)
    {
        return $this->repository->find($id);
    }
}