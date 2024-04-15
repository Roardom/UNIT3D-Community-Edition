<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dumps the contents of the database to disk in a format suitable for import with db:load';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $outfile = config('database.pristine-db-file');
        $host = config('database.connections.mysql.host');
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        if (!$outfile) {
            $this->error('The dump file location is not set in the configuration. If you\'ve tried to set it, you may need to call "php artisan cache:clear" and/or specify the environment when calling Artisan, e.g., "php artisan --env=testing db:dump".');

            return;
        }

        // Necessary to avoid warning about supplying password on CLI.

        putenv(sprintf('MYSQL_PWD=%s', $password));

        $cmd = sprintf(
            'mysqldump --user=%s --databases %s --add-drop-database --add-drop-table --default-character-set=utf8mb4 --skip-extended-insert --host=%s --quick --quote-names --routines --set-charset --single-transaction --triggers --tz-utc %s> %s;',
            escapeshellarg((string) $user),
            escapeshellarg((string) $db),
            escapeshellarg((string) $host),
            $this->option('verbose') ? '--verbose ' : '',
            escapeshellarg((string) $outfile)
        );

        $return = null;

        $output = null;

        exec($cmd, $output, $return);

        if ($return !== 0) {
            $this->error(sprintf('Could not dump database to file %s', $outfile));
        }
    }
}
