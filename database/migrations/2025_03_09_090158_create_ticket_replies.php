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
 * @author     Roardom <roardom@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_replies', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('content');
            $table->boolean('anon');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('ticket_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnUpdate()->cascadeOnDelete();
        });

        DB::table('comments')->where('commentable_type', '=', 'App\Models\Ticket')->lazyById()->each(function ($comment): void {
            $ticketExists = DB::table('tickets')->where('id', '=', $comment->commentable_id)->exists();

            if ($ticketExists) {
                DB::table('ticket_replies')->insert([
                    'content'    => $comment->content,
                    'anon'       => $comment->anon,
                    'user_id'    => $comment->user_id,
                    'ticket_id'  => $comment->commentable_id,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                ]);
            }

            // $comment->delete();
        });
    }
};
