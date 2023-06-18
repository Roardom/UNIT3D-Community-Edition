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
use App\Http\Requests\Staff\StoreRssRequest;
use App\Http\Requests\Staff\UpdateRssRequest;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Resolution;
use App\Models\Rss;
use App\Models\Type;
use Illuminate\Http\Request;
use Exception;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\RssControllerTest
 */
class RssController extends Controller
{
    /**
     * Display a listing of the RSS resource.
     */
    public function index($hash = null): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('Staff.rss.index', [
            'hash'       => $hash,
            'public_rss' => Rss::where('is_private', '=', 0)->orderBy('position')->get(),
        ]);
    }

    /**
     * Show the form for creating a new RSS resource.
     */
    public function create(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.rss.create', [
            'categories'  => Category::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'types'       => Type::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'resolutions' => Resolution::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'genres'      => Genre::orderBy('name')->get(),
            'user'        => $request->user(),
        ]);
    }

    /**
     * Store a newly created RSS resource in storage.
     */
    public function store(StoreRssRequest $request): \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
    {
        $rss = new Rss();
        $rss->name = $request->name;
        $rss->user_id = $request->user()->id;
        $rss->json_torrent = array_merge($rss->expected_fields, $request->validated());
        $rss->is_private = 0;
        $rss->position = $request->position;
        $rss->save();

        return to_route('staff.rss.index')
            ->withSuccess('Public RSS Feed Created');
    }

    /**
     * Show the form for editing the specified RSS resource.
     */
    public function edit(Request $request, int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.rss.edit', [
            'categories'  => Category::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'types'       => Type::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'resolutions' => Resolution::select(['id', 'name', 'position'])->get()->sortBy('position'),
            'genres'      => Genre::orderBy('name')->get(),
            'user'        => $request->user(),
            'rss'         => Rss::where('is_private', '=', 0)->findOrFail($id),
        ]);
    }

    /**
     * Update the specified RSS resource in storage.
     */
    public function update(UpdateRssRequest $request, int $id): \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
    {
        $rss = Rss::where('is_private', '=', 0)->findOrFail($id);

        $rss->update([
            'json_torrent' => array_merge($rss->json_torrent, $rss->expected_fields, $request->validated()),
            'name'         => $request->name,
            'position'     => $request->position,
        ]);

        return to_route('staff.rss.index')
            ->withSuccess('Public RSS Feed Updated');
    }

    /**
     * Remove the specified RSS resource from storage.
     *
     * @throws Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
    {
        Rss::where('is_private', '=', 0)->findOrFail($id)->delete();

        return to_route('staff.rss.index')
            ->withSuccess('RSS Feed Deleted!');
    }
}
