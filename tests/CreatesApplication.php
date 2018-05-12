<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
//        $this->_generateProcessId();
        $process = $this->_getProcessId();

        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=database/pmanager' . $process);
        putenv('SESSION_DRIVER=array');


        $app = include __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Get Processs Id
     *
     * @return string
     */
    private function _getProcessId()
    {
        $process = getenv('PROCESS_ID', '');
        return $process;
    }

    /**
     * Generate process id
     *
     * @return void
     */
    private function _generateProcessId()
    {
        putenv('PROCESS_ID=' . uniqid());
    }

    /**
     * Set Process Id to null
     *
     * @return void
     */
    private function _resetProcessId()
    {
        putenv('PROCESS_ID');
    }
}
