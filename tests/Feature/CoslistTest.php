<?php

namespace Tests\Feature;

use App\Models\Coslist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoslistTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_coslist_index_loads(): void
    {
        Coslist::factory(3)->create();
        $this->get(route('admin.clan.coslist.index'))->assertOk();
    }

    public function test_store_personal_and_guild_entries(): void
    {
        // No auth required by current routes; if protected later, act as admin
        $this->post(route('admin.clan.coslist.store.personal'), [
            'nicname' => 'Player1',
            'guild' => 'GuildA',
            'reason' => 'Reason A',
            'repayment' => '1000',
        ])->assertRedirect(route('admin.clan.coslist.index'));

        $this->assertDatabaseHas('coslists', [
            'nicname' => 'Player1',
            'guild' => 'GuildA',
            'master' => '-',
        ]);

        $this->post(route('admin.clan.coslist.store.guild'), [
            'guild' => 'GuildB',
            'master' => 'MasterB',
            'reason' => 'Reason B',
            'repayment' => '2000',
        ])->assertRedirect(route('admin.clan.coslist.index'));

        $this->assertDatabaseHas('coslists', [
            'nicname' => '-',
            'guild' => 'GuildB',
            'master' => 'MasterB',
        ]);
    }

    public function test_delete_entry(): void
    {
        $entry = Coslist::factory()->create();
        $this->delete(route('admin.clan.coslist.delete', $entry))->assertRedirect(route('admin.clan.coslist.index'));
        $this->assertDatabaseMissing('coslists', ['id' => $entry->id]);
    }
}


