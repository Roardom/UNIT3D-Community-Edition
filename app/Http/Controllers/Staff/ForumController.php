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
use App\Http\Requests\Staff\StoreForumRequest;
use App\Http\Requests\Staff\UpdateForumRequest;
use App\Models\Forum;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Support\Str;
use Exception;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\ForumControllerTest
 */
class ForumController extends Controller
{
    /**
     * Display All Forums.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.forum.index', [
            'categories' => Forum::where('parent_id', '=', 0)->orderBy('position')->get(),
        ]);
    }

    /**
     * Show Forum Create Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.forum.create', [
            'categories' => Forum::where('parent_id', '=', 0)->get(),
            'groups'     => Group::all()
        ]);
    }

    /**
     * Store A New Forum.
     */
    public function store(StoreForumRequest $request): \Illuminate\Http\RedirectResponse
    {
        $groups = Group::all();

        $forum = Forum::create(
            ['slug' => Str::slug($request->title)]
            + $request->safe()->only(
                [
                    'name',
                    'position',
                    'description',
                    'parent_id'
                ]
            )
        );

        // Permissions
        foreach ($groups as $group) {
            $permission = Permission::where('forum_id', '=', $forum->id)->where('group_id', '=', $group->id)->first();

            if ($permission == null) {
                $permission = new Permission();
            }

            $permission->forum_id = $forum->id;
            $permission->group_id = $group->id;

            if (\array_key_exists($group->id, $request->input('permissions'))) {
                $permission->show_forum = isset($request->input('permissions')[$group->id]['show_forum']);
                $permission->read_topic = isset($request->input('permissions')[$group->id]['read_topic']);
                $permission->reply_topic = isset($request->input('permissions')[$group->id]['reply_topic']);
                $permission->start_topic = isset($request->input('permissions')[$group->id]['start_topic']);
            } else {
                $permission->show_forum = false;
                $permission->read_topic = false;
                $permission->reply_topic = false;
                $permission->start_topic = false;
            }

            $permission->save();
        }

        return to_route('staff.forums.index')
            ->withSuccess('Forum has been created successfully');
    }

    /**
     * Forum Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.forum.edit', [
            'categories' => Forum::where('parent_id', '=', 0)->get(),
            'groups'     => Group::all(),
            'forum'      => Forum::findOrFail($id),
        ]);
    }

    /**
     * Edit A Forum.
     */
    public function update(UpdateForumRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $groups = Group::all();

        Forum::where('id', '=', $id)->update(
            [
                'slug'      => Str::slug($request->title),
                'parent_id' => $request->forum_type === 'category' ? 0 : $request->parent_id,
            ]
            + $request->safe()->only(['name', 'position', 'description'])
        );

        // Permissions
        foreach ($groups as $group) {
            $permission = Permission::where('forum_id', '=', $id)->where('group_id', '=', $group->id)->first();

            if ($permission === null) {
                $permission = new Permission();
            }

            $permission->forum_id = $id;
            $permission->group_id = $group->id;

            if (\array_key_exists($group->id, $request->input('permissions'))) {
                $permission->show_forum = isset($request->input('permissions')[$group->id]['show_forum']);
                $permission->read_topic = isset($request->input('permissions')[$group->id]['read_topic']);
                $permission->reply_topic = isset($request->input('permissions')[$group->id]['reply_topic']);
                $permission->start_topic = isset($request->input('permissions')[$group->id]['start_topic']);
            } else {
                $permission->show_forum = false;
                $permission->read_topic = false;
                $permission->reply_topic = false;
                $permission->start_topic = false;
            }

            $permission->save();
        }

        return to_route('staff.forums.index')
            ->withSuccess('Forum has been edited successfully');
    }

    /**
     * Delete A Forum.
     *
     * @throws Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $forum = Forum::findOrFail($id);

        $permissions = Permission::where('forum_id', '=', $forum->id)->get();

        foreach ($permissions as $permission) {
            $permission->delete();
        }

        unset($permissions);

        if ($forum->parent_id == 0) {
            $category = $forum;
            $permissions = Permission::where('forum_id', '=', $category->id)->get();

            foreach ($permissions as $post) {
                $post->delete();
            }

            foreach ($category->getForumsInCategory() as $forum) {
                $permissions = Permission::where('forum_id', '=', $forum->id)->get();

                foreach ($permissions as $p) {
                    $p->delete();
                }

                foreach ($forum->topics as $topic) {
                    foreach ($topic->posts as $post) {
                        $post->delete();
                    }

                    $topic->delete();
                }

                $forum->delete();
            }

            $category->delete();
        } else {
            $permissions = Permission::where('forum_id', '=', $forum->id)->get();

            foreach ($permissions as $permission) {
                $permission->delete();
            }

            foreach ($forum->topics as $topic) {
                foreach ($topic->posts as $post) {
                    $post->delete();
                }

                $topic->delete();
            }

            $forum->delete();
        }

        return to_route('staff.forums.index')
            ->withSuccess('Forum has been deleted successfully');
    }
}
