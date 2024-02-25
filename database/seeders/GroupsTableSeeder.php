<?php
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

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        Group::upsert([
            [
                'name'             => 'Validating',
                'slug'             => 'validating',
                'position'         => 4,
                'color'            => '#95A5A6',
                'icon'             => config('other.font-awesome').' fa-question-circle',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Guest',
                'slug'             => 'guest',
                'position'         => 3,
                'color'            => '#575757',
                'icon'             => config('other.font-awesome').' fa-question-circle',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 10,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'User',
                'slug'             => 'user',
                'position'         => 6,
                'color'            => '#7289DA',
                'icon'             => config('other.font-awesome').' fa-user',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 30,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Administrator',
                'slug'             => 'administrator',
                'position'         => 18,
                'color'            => '#f92672',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 1,
                'is_modo'          => 1,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 1,
                'level'            => 5000,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Banned',
                'slug'             => 'banned',
                'position'         => 1,
                'color'            => 'red',
                'icon'             => config('other.font-awesome').' fa-ban',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Moderator',
                'slug'             => 'moderator',
                'position'         => 17,
                'color'            => '#4ECDC4',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 1,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 1,
                'level'            => 2500,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Uploader',
                'slug'             => 'uploader',
                'position'         => 15,
                'color'            => '#2ECC71',
                'icon'             => config('other.font-awesome').' fa-upload',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 1,
                'is_immune'        => 1,
                'level'            => 250,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Trustee',
                'slug'             => 'trustee',
                'position'         => 16,
                'color'            => '#BF55EC',
                'icon'             => config('other.font-awesome').' fa-shield',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 1,
                'is_immune'        => 1,
                'level'            => 1000,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Bot',
                'slug'             => 'bot',
                'position'         => 20,
                'color'            => '#f1c40f',
                'icon'             => 'fab fa-android',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 1,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Owner',
                'slug'             => 'owner',
                'position'         => 19,
                'color'            => '#00abff',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 1,
                'is_admin'         => 1,
                'is_modo'          => 1,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 1,
                'level'            => 9999,
                'min_uploaded'     => 0,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 0,
            ],
            [
                'name'             => 'PowerUser',
                'slug'             => 'poweruser',
                'position'         => 7,
                'color'            => '#3c78d8',
                'icon'             => config('other.font-awesome').' fa-user-circle',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 40,
                'min_uploaded'     => 1024 * 1024 * 1024 * 1024,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 30 * 24 * 3600,
            ],
            [
                'name'             => 'SuperUser',
                'slug'             => 'superuser',
                'position'         => 8,
                'color'            => '#1155cc',
                'icon'             => config('other.font-awesome').' fa-power-off',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 50,
                'min_uploaded'     => 5 * 1024 * 1024 * 1024 * 1024,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 60 * 24 * 3600,
            ],
            [
                'name'             => 'ExtremeUser',
                'slug'             => 'extremeuser',
                'position'         => 9,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-bolt',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 60,
                'min_uploaded'     => 20 * 1024 * 1024 * 1024 * 1024,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 90 * 24 * 3600,
            ],
            [
                'name'             => 'InsaneUser',
                'slug'             => 'insaneuser',
                'position'         => 10,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-rocket',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 70,
                'min_uploaded'     => 50 * 1024 * 1024 * 1024 * 1024,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 180 * 24 * 3600,
            ],
            [
                'name'             => 'Leech',
                'slug'             => 'leech',
                'position'         => 5,
                'color'            => '#96281B',
                'icon'             => config('other.font-awesome').' fa-times',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 20,
                'min_uploaded'     => 0,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0,
                'min_age'          => 0,
            ],
            [
                'name'             => 'Veteran',
                'slug'             => 'veteran',
                'position'         => 11,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-key',
                'effect'           => 'url(/img/sparkels.gif)',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 1,
                'is_immune'        => 0,
                'level'            => 100,
                'min_uploaded'     => 100 * 1024 * 1024 * 1024 * 1024,
                'min_seedsize'     => 0,
                'min_avg_seedtime' => 0,
                'min_ratio'        => 0.4,
                'min_age'          => 365 * 24 * 3600,
            ],
            [
                'name'             => 'Seeder',
                'slug'             => 'seeder',
                'position'         => 12,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-hdd',
                'effect'           => 'none',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 0,
                'is_immune'        => 1,
                'level'            => 80,
                'min_uploaded'     => 0,
                'min_seedsize'     => 5 * 1024 * 1024 * 1024 * 1024,
                'min_avg_seedtime' => 30 * 24 * 3600,
                'min_ratio'        => 0.4,
                'min_age'          => 30 * 24 * 3600,
            ],
            [
                'name'             => 'Archivist',
                'slug'             => 'archivist',
                'position'         => 13,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-server',
                'effect'           => 'url(/img/sparkels.gif)',
                'autogroup'        => 1,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 1,
                'is_immune'        => 1,
                'level'            => 90,
                'min_uploaded'     => 0,
                'min_seedsize'     => 10 * 1024 * 1024 * 1024 * 1024,
                'min_avg_seedtime' => 60 * 24 * 3600,
                'min_ratio'        => 0.4,
                'min_age'          => 90 * 24 * 3600,
            ],
            [
                'name'             => 'Internal',
                'slug'             => 'internal',
                'position'         => 14,
                'color'            => '#BAAF92',
                'icon'             => config('other.font-awesome').' fa-magic',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 1,
                'is_trusted'       => 1,
                'is_freeleech'     => 1,
                'is_immune'        => 1,
                'level'            => 500,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Disabled',
                'slug'             => 'disabled',
                'position'         => 2,
                'color'            => '#8D6262',
                'icon'             => config('other.font-awesome').' fa-pause-circle',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Pruned',
                'slug'             => 'pruned',
                'position'         => 0,
                'color'            => '#8D6262',
                'icon'             => config('other.font-awesome').' fa-times-circle',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => true,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 0,
                'is_internal'      => 0,
                'is_trusted'       => 0,
                'is_freeleech'     => 0,
                'is_immune'        => 0,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
            [
                'name'             => 'Editor',
                'slug'             => 'editor',
                'position'         => 17,
                'color'            => '#15B097',
                'icon'             => config('other.font-awesome').' fa-user-pen',
                'effect'           => 'none',
                'autogroup'        => 0,
                'system_required'  => false,
                'is_owner'         => 0,
                'is_admin'         => 0,
                'is_modo'          => 0,
                'is_editor'        => 1,
                'is_internal'      => 0,
                'is_trusted'       => 1,
                'is_freeleech'     => 1,
                'is_immune'        => 1,
                'level'            => 0,
                'min_uploaded'     => null,
                'min_seedsize'     => null,
                'min_avg_seedtime' => null,
                'min_ratio'        => null,
                'min_age'          => null,
            ],
        ], ['slug'], []);
    }
}
