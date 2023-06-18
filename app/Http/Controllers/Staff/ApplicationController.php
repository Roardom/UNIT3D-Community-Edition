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
use App\Mail\DenyApplication;
use App\Mail\InviteUser;
use App\Models\Application;
use App\Models\Invite;
use App\Rules\EmailBlacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Exception;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\ApplicationControllerTest
 */
class ApplicationController extends Controller
{
    /**
     * Display All Applications.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.application.index', [
            'applications' => Application::withAnyStatus()
                ->with(['user', 'moderated', 'imageProofs', 'urlProofs'])
                ->latest()
                ->paginate(25),
        ]);
    }

    /**
     * Get A Application.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $application = Application::withAnyStatus()->with(['user', 'moderated', 'imageProofs', 'urlProofs'])->findOrFail($id);

        return view('Staff.application.show', ['application' => $application]);
    }

    /**
     * Approve A Application.
     *
     * @throws Exception
     */
    public function approve(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 1,
            'email'  => [
                'required',
                'string',
                'email',
                'max:70',
                'unique:invites',
                'unique:users',
                Rule::when(config('email-blacklist.enabled'), fn () => new EmailBlacklist()),
            ],
            'approve' => 'required',
        ]);

        $application = Application::withAnyStatus()->findOrFail($id);

        $invite = Invite::create([
            'user_id'    => $request->user()->id,
            'email'      => $application->email,
            'code'       => Uuid::uuid4()->toString(),
            'expires_on' => now()->addDays(config('other.invite_expire')),
            'custom'     => $request->string('approve'),
        ]);

        Mail::to($application->email)->send(new InviteUser($invite));

        $application->markApproved();

        return to_route('staff.applications.index')
            ->withSuccess('Application Approved');
    }

    /**
     * Reject A Application.
     */
    public function reject(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 2,
            'deny'   => 'required'
        ]);

        $application = Application::withAnyStatus()->findOrFail($id);
        $application->markRejected();

        Mail::to($application->email)->send(new DenyApplication($request->deny));

        return to_route('staff.applications.index')
            ->withSuccess('Application Rejected');
    }
}
