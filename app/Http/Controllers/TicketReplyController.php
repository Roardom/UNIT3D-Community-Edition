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

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketReplyRequest;
use App\Http\Requests\UpdateTicketReplyRequest;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewComment;
use Illuminate\Support\Facades\Notification;

class TicketReplyController extends Controller
{
    final public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('ticket.index');
    }

    final public function store(Ticket $ticket, StoreTicketReplyRequest $request): \Illuminate\Http\RedirectResponse
    {
        abort_unless($request->user()->group->is_modo || $ticket->user_id === $request->user()->id, 403);

        $ticketReply = $ticket->replies()->create([...$request->validated(), 'user_id' => $request->user()->id]);

        if ($request->user()->id !== $ticket->staff_id && $ticket->staff_id !== null) {
            User::find($ticket->staff_id)->notify(new NewComment($ticket, $ticketReply));
            $ticket->update(['staff_read' => false]);
        }

        if ($request->user()->id !== $ticket->user_id) {
            User::find($ticket->user_id)->notify(new NewComment($ticket, $ticketReply));
            $ticket->update(['user_read' => false]);
        }

        $ticketReplyUsers = User::query()
            ->whereRelation('ticketReplies', 'id', '=', $ticket->id)
            ->whereNotIn('users.id', [$ticket->user_id, $ticket->staff_id])
            ->get();

        Notification::send($ticketReplyUsers, new NewComment($ticket, $ticketReply));

        return to_route('tickets.show', ['ticket' => $ticket])
            ->with('success', trans('ticket.created-success'));
    }

    final public function update(Ticket $ticket, TicketReply $ticketReply, UpdateTicketReplyRequest $request): \Illuminate\Http\RedirectResponse
    {
        abort_unless($request->user()->group->is_modo || $ticket->user_id === $request->user()->id, 403);

        $ticketReply->update($request->validated());

        return to_route('tickets.show', ['ticket' => $ticket])
            ->with('success', trans('ticket.created-success'));
    }

    final public function edit(Ticket $ticket, TicketReply $ticketReply, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        abort_unless($request->user()->group->is_modo || $ticket->user_id === $request->user()->id, 403);

        return view('ticket.reply.edit', [
            'ticket'      => $ticket,
            'ticketReply' => $ticketReply,
        ]);
    }

    final public function destroy(Ticket $ticket, TicketReply $ticketReply, Request $request): \Illuminate\Http\RedirectResponse
    {
        abort_unless($request->user()->group->is_modo || $ticket->user_id === $request->user()->id, 403);

        $ticketReply->delete();

        return to_route('tickets.show', ['ticket' => $ticket])
            ->with('success', trans('ticket.deleted-success'));
    }
}
