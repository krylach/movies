<?php

namespace Engine;

use App\Kernel;

class Application
{
    private Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        session_start();
        $this->kernel = $kernel;
    }

    public function run()
    {
        print $this->kernel->handler();
    }

    public function __destruct()
    {
        session_commit();
        session_abort();
    }
}