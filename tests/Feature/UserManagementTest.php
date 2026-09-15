<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_bisa_mengakses_halaman_manajemen_user(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('index'));

        $response->assertStatus(200);
        $response->assertSee('User P3M Polibang Jepara');
    }

    #[Test]
    public function edit_user_dengan_email_milik_user_lain_gagal_validasi_dan_tidak_crash(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@polibang.ac.id',
            'name' => 'Admin Utama',
        ]);

        $dosen1 = User::factory()->dosen()->create([
            'email' => 'pengelola@polibang.ac.id',
            'name' => 'Pengelola P3M',
        ]);

        $dosen2 = User::factory()->dosen()->create([
            'email' => 'muhammadbahaudinnajib@gmail.com',
            'name' => 'Najibb',
        ]);

        // Attempt to update $dosen1 with $dosen2's email
        $payload = [
            'name' => 'Pengelola P3M Update',
            'email' => 'muhammadbahaudinnajib@gmail.com', // Duplicate of $dosen2
            'role' => 'admin',
        ];

        $response = $this->actingAs($admin)->put(route('edit', ['id' => $dosen1->id]), $payload);

        $response->assertSessionHasErrors('email');
        $response->assertSessionHas('form_context', 'edit_user_' . $dosen1->id);

        // Ensure database record was NOT changed
        $this->assertDatabaseHas('users', [
            'id' => $dosen1->id,
            'email' => 'pengelola@polibang.ac.id',
        ]);
    }

    #[Test]
    public function edit_user_dengan_email_dan_nama_milik_sendiri_berhasil(): void
    {
        $admin = User::factory()->admin()->create();

        $user = User::factory()->dosen()->create([
            'name' => 'Dosen Tetap',
            'email' => 'dosen.tetap@polibang.ac.id',
        ]);

        $payload = [
            'name' => 'Dosen Tetap', // Same name
            'email' => 'dosen.tetap@polibang.ac.id', // Same email
            'role' => 'admin', // Upgrade role
        ];

        $response = $this->actingAs($admin)->put(route('edit', ['id' => $user->id]), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'admin',
        ]);
    }

    #[Test]
    public function edit_user_dengan_email_baru_yang_belum_digunakan_berhasil(): void
    {
        $admin = User::factory()->admin()->create();

        $user = User::factory()->dosen()->create([
            'name' => 'User Lama',
            'email' => 'user.lama@polibang.ac.id',
        ]);

        $payload = [
            'name' => 'User Baru',
            'email' => 'user.baru@polibang.ac.id',
            'role' => 'dosen',
        ];

        $response = $this->actingAs($admin)->put(route('edit', ['id' => $user->id]), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'User Baru',
            'email' => 'user.baru@polibang.ac.id',
        ]);
    }

    #[Test]
    public function tambah_user_dengan_email_duplikat_gagal_validasi(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();

        User::factory()->dosen()->create([
            'email' => 'existing@polibang.ac.id',
            'name' => 'Existing User',
        ]);

        $photo = UploadedFile::fake()->image('profile.jpg', 200, 200);

        $payload = [
            'name' => 'New Unique Name',
            'email' => 'existing@polibang.ac.id', // Duplicate
            'password' => 'secret123',
            'role' => 'dosen',
            'image' => $photo,
        ];

        $response = $this->actingAs($admin)->post(route('store'), $payload);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => 'New Unique Name',
        ]);
    }
}
