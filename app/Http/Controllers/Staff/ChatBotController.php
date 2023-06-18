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

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateChatBotRequest;
use App\Models\Bot;
use Illuminate\Http\Request;
use Exception;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\ChatBotControllerTest
 */
class ChatBotController extends Controller
{
    /**
     * Display a listing of the Bots resource.
     */
    public function index($hash = null): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('Staff.chat.bot.index', [
            'bots' => Bot::orderByDesc('position')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified Bot resource.
     */
    public function edit(Request $request, int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('Staff.chat.bot.edit', [
            'user' => $request->user(),
            'bot'  => Bot::findOrFail($id),
        ]);
    }

    /**
     * Update the specified Bot resource in storage.
     */
    public function update(UpdateChatBotRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        return to_route('staff.bots.edit', [
            'id' => Bot::where('id', '=', $id)->update($request->validated())
        ])
            ->withSuccess("The Bot Has Been Updated");
    }

    /**
     * Remove the specified Bot resource from storage.
     *
     * @throws Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        Bot::findOrFail($id)->where('is_protected', '=', false)->delete();

        return to_route('staff.bots.index')
            ->withSuccess('The Humans Vs Machines War Has Begun! Humans: 1 and Bots: 0');
    }

    /**
     * Disable the specified Bot resource in storage.
     */
    public function disable(int $id): \Illuminate\Http\RedirectResponse
    {
        Bot::findOrFail($id)->update(['active' => false]);

        return to_route('staff.bots.index')
            ->withSuccess('The Bot Has Been Disabled');
    }

    /**
     * Enable the specified Bot resource in storage.
     */
    public function enable(int $id): \Illuminate\Http\RedirectResponse
    {
        Bot::findOrFail($id)->update(['active' => true]);

        return to_route('staff.bots.index')
            ->withSuccess('The Bot Has Been Enabled');
    }
}
