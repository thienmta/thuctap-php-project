<?php

namespace Tests;

use App\Model\User;
//use Illuminate\Contracts\Console\Kernel;
use Session;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost:8877';

    /**
     * List of table in db
     *
     * @var array
     */
    protected $tables;

    /**
     * Name of db
     *
     * @var string
     */
    protected $dbname;

    /**
     * List table user
     *
     * @var array
     */
    protected $userTables = [

    ];

    /**
     * Function set up
     *
     * @return void
     */
    public function setUp()
    {
        /**
         * Function set up
         *
         * @return void
         */
        parent::setUp();
        $this->truncateCommon();
        Session::start();
    }

    /**
     * Set authorization
     *
     * @param int $id user id
     *
     * @return void
     */
    public function authorization($id = null)
    {
        $user = null;
        if ($id) {
            $user = User::find($id);
        } else {
            $user = User::first();
        }

        if ($user) {
            $this->be($user);
        }

        return $user;
    }

    /**
     * Truncate all table
     *
     * @return null
     */
    public function truncateCommon()
    {
        if ('sqlite' === getenv('DB_CONNECTION')) {
            $this->_setupSQLiteDb();
        } else {
            $this->_setupMySQLDb();
        }

    }

    /**
     * Setup SQLite DB
     *
     * @return void
     */
    private function _setupSQLiteDb()
    {
        if ('sqlite' === getenv('DB_CONNECTION')) {
            $process = $this->_getProcessId();

            copy(
                __DIR__ . '/../database/backup/pmanager.sqlite',
                $this->_getDataFilename($process)
            );
        }
    }

    /**
     * Get full file path from process id
     *
     * @param string $process process id
     *
     * @return string
     */
    private function _getDataFilename($process)
    {
        return __DIR__ . '/../database/pmanager' . $process;
    }

    /**
     * Reset MySQL DB
     *
     * @return void
     */
    private function _setupMySQLDb()
    {
        $excludeTable = [
            'crm_zipcode' => true,
            'permissions' => true,
            'permission_role' => true,
            'assigned_roles' => true,
            'migrations' => true,
            'roles' => true,
            'users' => true
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (!isset($this->tables)) {
            $this->tables = DB::select('SHOW TABLES');
            $this->dbname = getenv('DB_DATABASE');
        }

        foreach ($this->tables as $name) {
            $tableName = $name->{'Tables_in_' . $this->dbname};
            if (isset($excludeTable[$tableName])) {
                continue;
            }

            DB::table($tableName)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
