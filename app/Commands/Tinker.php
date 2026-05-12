<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Tinker extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Development';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'tinker';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Interact with your application.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'tinker';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        if (! class_exists(\Psy\Shell::class)) {
            CLI::error('PsySH is not installed. Silakan install dengan menjalankan: composer require --dev psy/psysh');
            return;
        }

        CLI::write('Tinker Starting...', 'green');
        $shell = new \Psy\Shell();
        $shell->run();
    }
}
