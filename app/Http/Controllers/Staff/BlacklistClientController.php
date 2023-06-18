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
use App\Http\Requests\Staff\StoreBlacklistClientRequest;
use App\Http\Requests\Staff\UpdateBlacklistClientRequest;
use App\Models\BlacklistClient;
use App\Services\Unit3dAnnounce;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\GroupControllerTest
 */
class BlacklistClientController extends Controller
{
    /**
     * Display All Blacklisted Clients.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.blacklist.clients.index', [
            'clients' => BlacklistClient::latest()->get(),
        ]);
    }

    /**
     * Blacklisted Client Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('Staff.blacklist.clients.edit', [
            'client' => BlacklistClient::findOrFail($id),
        ]);
    }

    /**
     * Edit A Blacklisted Client.
     */
    public function update(UpdateBlacklistClientRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $client = BlacklistClient::findOrFail($id);

        Unit3dAnnounce::removeBlacklistedAgent($client);

        $client->update($request->validated());

        Unit3dAnnounce::addBlacklistedAgent($client);

        cache()->forget('client_blacklist');

        return to_route('staff.blacklists.clients.index')
            ->withSuccess('Blacklisted Client Was Updated Successfully!');
    }

    /**
     * Blacklisted Client Add Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.blacklist.clients.create');
    }

    /**
     * Store A New Blacklisted Client.
     */
    public function store(StoreBlacklistClientRequest $request): \Illuminate\Http\RedirectResponse
    {
        $client = BlacklistClient::create($request->validated());

        Unit3dAnnounce::addBlacklistedAgent($client);

        cache()->forget('client_blacklist');

        return to_route('staff.blacklists.clients.index')
            ->withSuccess('Blacklisted Client Stored Successfully!');
    }

    /**
     * Delete A Blacklisted Client.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $client = BlacklistClient::findOrFail($id);

        Unit3dAnnounce::removeBlacklistedAgent($client);

        $client->delete();

        cache()->forget('client_blacklist');

        return to_route('staff.blacklists.clients.index')
            ->withSuccess('Blacklisted Client Destroyed Successfully!');
    }
}
