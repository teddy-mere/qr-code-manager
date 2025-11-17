<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\QrCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use tbQuar\Facades\Quar;

class QrCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Quar::partialMock()
            ->shouldReceive('size')->andReturnSelf()
            ->shouldReceive('format')->andReturnSelf()
            ->shouldReceive('generate')->andReturn('qr-content');
    }

    public function test_index_returns_qrcodes_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('qrcodes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('qrcodes.index');
    }

    public function test_create_returns_create_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('qrcodes.create'));

        $response->assertStatus(200);
        $response->assertViewIs('qrcodes.create');
    }

    public function test_store_creates_qrcode_and_file()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('qrcodes.store'), [
            'title' => 'Test QR',
            'fields' => [
                ['label' => 'Label1', 'value' => 'Value1']
            ]
        ]);

        $response->assertRedirect(route('qrcodes.index'));
        $this->assertDatabaseHas('qr_codes', ['title' => 'Test QR']);
        Storage::disk('public')->assertExists(
            'qrcodes/' . QrCode::first()->uuid . '.svg'
        );
    }

    public function test_edit_returns_edit_view()
    {
        $user = User::factory()->create();
        $qr = QrCode::factory()->create();

        $response = $this->actingAs($user)->get(
            route('qrcodes.edit', ['qrcode' => $qr->uuid])
        );

        $response->assertStatus(200);
        $response->assertViewIs('qrcodes.edit');
        $response->assertViewHas('qrcode', $qr);
    }

    public function test_update_modifies_qrcode()
    {
        $user = User::factory()->create();
        $qr = QrCode::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($user)->put(
            route('qrcodes.update', ['qrcode' => $qr->uuid]),
            [
                'title' => 'Updated QR',
                'fields' => [
                    ['label' => 'New Label', 'value' => 'New Value']
                ]
            ]
        );

        $response->assertRedirect(route('qrcodes.index'));
        $this->assertEquals('Updated QR', $qr->fresh()->title);
        Storage::disk('public')->assertExists(
            'qrcodes/' . $qr->uuid . '.svg'
        );
    }

    public function test_destroy_deletes_qrcode_and_file()
    {
        $user = User::factory()->create();
        $qr = QrCode::factory()->create();

        Storage::disk('public')->put('qrcodes/' . $qr->uuid . '.svg', 'dummy');

        $response = $this->actingAs($user)->delete(
            route('qrcodes.destroy', ['qrcode' => $qr->uuid])
        );

        $response->assertRedirect(route('qrcodes.index'));
        $this->assertDatabaseMissing('qr_codes', ['uuid' => $qr->uuid]);
        Storage::disk('public')->assertMissing('qrcodes/' . $qr->uuid . '.svg');
    }

    public function test_show_returns_qrcode_view()
    {
        $qr = QrCode::factory()->create();

        $response = $this->get(route('qrcodes.show', ['uuid' => $qr->uuid]));

        $response->assertStatus(200);
        $response->assertViewIs('qrcodes.show');
        $response->assertViewHas('qrcode', $qr);
    }
}
