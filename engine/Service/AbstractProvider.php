<?php

namespace Engine\Service;

use Engine\DI\DI;

abstract class AbstractProvider
{
    /**
     * @var
     */
    protected $di;

    /**
     * AbstractProvider constructor.
     * @param \Engine\DI\DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
    }
    abstract public function init();
}
