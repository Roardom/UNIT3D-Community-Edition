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
 * @author     HDVinnie
 */

namespace App\Models;

use App\Helpers\Bbcode;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $subject
 * @property string $message
 * @property int $read
 * @property int|null $related_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $receiver
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereRelatedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PrivateMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PrivateMessage extends Model
{
    /**
     * Belongs To A User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Belongs To A User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Set The PM Message After Its Been Purified.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = htmlspecialchars($value);
    }

    /**
     * Parse Content And Return Valid HTML.
     *
     * @return string Parsed BBCODE To HTML
     */
    public function getMessageHtml()
    {
        $bbcode = new Bbcode();

        return $bbcode->parse($this->message, true);
    }
}
