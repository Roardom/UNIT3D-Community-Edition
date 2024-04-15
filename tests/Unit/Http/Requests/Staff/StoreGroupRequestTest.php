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

use App\Http\Requests\Staff\StoreGroupRequest;

beforeEach(function (): void {
    $this->subject = new StoreGroupRequest();
});

test('authorize', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $actual = $this->subject->authorize();

    expect($actual)->toBeTrue();
});

test('rules', function (): void {
    $actual = $this->subject->rules();

    $this->assertValidationRules([
        'name' => [
            'required',
            'string',
            'unique:groups',
        ],
        'position' => [
            'required',
            'integer',
        ],
        'level' => [
            'required',
            'integer',
        ],
        'download_slots' => [
            'nullable',
            'integer',
        ],
        'color' => [
            'required',
        ],
        'icon' => [
            'required',
        ],
        'effect' => [
            'sometimes',
        ],
        'is_internal' => [
            'required',
            'boolean',
        ],
        'is_editor' => [
            'required',
            'boolean',
        ],
        'is_modo' => [
            'required',
            'boolean',
        ],
        'is_admin' => [
            'required',
            'boolean',
        ],
        'is_owner' => [
            'required',
            'boolean',
        ],
        'is_trusted' => [
            'required',
            'boolean',
        ],
        'is_immune' => [
            'required',
            'boolean',
        ],
        'is_freeleech' => [
            'required',
            'boolean',
        ],
        'is_double_upload' => [
            'required',
            'boolean',
        ],
        'is_incognito' => [
            'required',
            'boolean',
        ],
        'can_upload' => [
            'required',
            'boolean',
        ],
        'autogroup' => [
            'required',
            'boolean',
        ],
    ], $actual);
});
