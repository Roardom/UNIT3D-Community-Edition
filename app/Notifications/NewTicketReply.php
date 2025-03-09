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

namespace App\Notifications;

use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTicketReply extends Notification
{
    use Queueable;

    /**
     * NewComment Constructor.
     */
    public function __construct(public TicketReply $ticketReply)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(User $notifiable): bool
    {
        // Do not notify self
        return ! ($this->ticketReply->user_id === $notifiable->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $username = $this->ticketReply->anon ? 'Anonymous' : $this->ticketReply->user->username;

        return [
            'title' => 'New Ticket Reply Received',
            'body'  => $username.' has left you a reply on ticket '.$this->ticketReply->ticket->subject,
            'url'   => '/tickets/'.$this->ticketReply->ticket_id.'#ticket-reply-'.$this->ticketReply->id,
        ];
    }
}
