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

namespace App\Models;

use App\Events\TicketWentStale;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment.
 *
 * @property int                             $id
 * @property string                          $content
 * @property int                             $anon
 * @property int                             $user_id
 * @property int                             $ticket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class TicketReply extends Model
{
    use Auditable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array{anon: 'bool'}
     */
    protected function casts(): array
    {
        return [
            'anon' => 'bool',
        ];
    }

    /**
     * Belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to a ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Ticket, $this>
     */
    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Notify Staff There Is Stale Tickets.
     */
    public static function checkForStale(Ticket $ticket): void
    {
        if (empty($ticket->reminded_at) || strtotime((string) $ticket->reminded_at) < strtotime('+ 3 days')) {
            $last_comment = $ticket->replies()->latest('id')->first();

            if ($last_comment !== null && property_exists($last_comment, 'id') && $last_comment->id !== null && !$last_comment->user->group->is_modo && strtotime((string) $last_comment->created_at) < strtotime('- 3 days')) {
                event(new TicketWentStale($ticket));
            }
        }
    }
}
