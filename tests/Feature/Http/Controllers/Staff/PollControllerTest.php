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

use App\Http\Controllers\Staff\PollController;
use App\Http\Requests\StorePoll;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Poll;
use App\Models\User;

test('create returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('staff.polls.create'));

    $response->assertOk();
    $response->assertViewIs('Staff.poll.create');

    // TODO: perform additional assertions
});

test('destroy returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $poll = Poll::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->delete(route('staff.polls.destroy', [$poll]));

    $response->assertOk();
    $this->assertModelMissing($poll);

    // TODO: perform additional assertions
});

test('edit returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $poll = Poll::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('staff.polls.edit', [$poll]));

    $response->assertOk();
    $response->assertViewIs('Staff.poll.edit');
    $response->assertViewHas('poll', $poll);

    // TODO: perform additional assertions
});

test('index returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $polls = Poll::factory()->times(3)->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('staff.polls.index'));

    $response->assertOk();
    $response->assertViewIs('Staff.poll.index');
    $response->assertViewHas('polls', $polls);

    // TODO: perform additional assertions
});

test('show returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $poll = Poll::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('staff.polls.show', [$poll]));

    $response->assertOk();
    $response->assertViewIs('Staff.poll.show');
    $response->assertViewHas('poll', $poll);

    // TODO: perform additional assertions
});

test('store validates with a form request', function (): void {
    $this->assertActionUsesFormRequest(
        PollController::class,
        'store',
        StorePoll::class
    );
});

test('store returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('staff.polls.store'), [
        // TODO: send request data
    ]);

    $response->assertOk();

    // TODO: perform additional assertions
});

test('update validates with a form request', function (): void {
    $this->assertActionUsesFormRequest(
        PollController::class,
        'update',
        UpdatePollRequest::class
    );
});

test('update returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $poll = Poll::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch(route('staff.polls.update', [$poll]), [
        // TODO: send request data
    ]);

    $response->assertOk();

    // TODO: perform additional assertions
});

// test cases...
