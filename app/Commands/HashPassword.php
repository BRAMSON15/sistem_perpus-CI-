<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class HashPassword extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:hash';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Hashes a password using password_hash().';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:hash [password]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'password' => 'The password to hash',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $password = array_shift($params);

        if (empty($password)) {
            $password = CLI::prompt('Enter your password');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        CLI::write("HASH_RESULT: {$hash}", 'blue');
    }
}
