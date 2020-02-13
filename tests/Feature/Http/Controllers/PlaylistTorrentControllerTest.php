<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlaylistTorrentController
 */
class PlaylistTorrentControllerTest extends TestCase
{


    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
$this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

$playlist_torrent = factory(\App\Models\PlaylistTorrent::class)->create();
$user = factory(\App\Models\User::class)->create();

$response = $this->actingAs($user)->delete(route('playlists.detach', ['id' => $playlist_torrent->id]));

$response->assertRedirect(withSuccess('Torrent Has Successfully Been Detached From Your Playlist.'));
$this->assertDeleted($playlists);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
$this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

$user = factory(\App\Models\User::class)->create();

$response = $this->actingAs($user)->post(route('playlists.attach'), [
            // TODO: send request data
        ]);

$response->assertRedirect(withErrors($v->errors()));

        // TODO: perform additional assertions
    }

    // test cases...
}
