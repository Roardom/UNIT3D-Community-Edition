<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     singularity43
 */

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class Chatter implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message details.
     *
     * @var Message
     */
    public $echoes;
    public $target;
    public $type;
    public $message;
    public $ping;
    public $audibles;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $target, $payload)
    {
        $this->type = $type;
        if ($type == 'echo') {
            $this->echoes = $payload;
        } elseif ($type == 'audible') {
            $this->audibles = $payload;
        } elseif ($type == 'new.message') {
            $this->message = $payload;
        } elseif ($type == 'new.bot') {
            $this->message = $payload;
        } elseif ($type == 'new.ping') {
            $this->ping = $payload;
        }
        $this->target = $target;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // $this->dontBroadcastToCurrentUser();

        return new PrivateChannel('chatter.'.$this->target);
    }
}
