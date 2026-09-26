<?php

namespace Tests\Feature;

use App\Models\M_Pengelola;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengelolaIdentitasTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->dosen = User::factory()->create([
            'role' => 'dosen',
        ]);

        Storage::fake('public');
    }

    public function test_guest_cannot_access_pengelola_index()
    {
        $response = $this->get(route('pengelola.index'));
        $response->assertRedirect('/login');
    }

    public function test_dosen_forbidden_from_pengelola_index()
    {
        $response = $this->actingAs($this->dosen)->get(route('pengelola.index'));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_admin_can_access_pengelola_index_and_sees_nidn_nuptk_column()
    {
        M_Pengelola::create([
            'nama_pengelola'    => 'Sofia Ulfah M.Kom',
            'jenis_identitas'   => 'NIDN',
            'NIDN'              => '06190990045',
            'jabatan_pengelola' => 'Ketua P3M',
            'email_pengelola'   => 'sofia@example.com',
            'image'             => 'sample1.webp',
        ]);

        M_Pengelola::create([
            'nama_pengelola'    => 'Budi Santoso, S.T',
            'jenis_identitas'   => 'NUPTK',
            'NIDN'              => '1234567890123456',
            'jabatan_pengelola' => 'Staf Administrasi P3M',
            'email_pengelola'   => 'budi@example.com',
            'image'             => 'sample2.webp',
        ]);

        $response = $this->actingAs($this->admin)->get(route('pengelola.index'));
        $response->assertStatus(200);

        // Verify column header
        $response->assertSee('NIDN/NUPTK');

        // Verify labels and values for both NIDN and NUPTK
        $response->assertSee('Sofia Ulfah M.Kom');
        $response->assertSee('06190990045');
        $response->assertSee('Budi Santoso, S.T');
        $response->assertSee('1234567890123456');

        // Verify form fields in modal
        $response->assertSee('Jenis Identitas');
        $response->assertSee('Nomor NIDN/NUPTK');
    }

    public function test_admin_can_create_pengelola_with_nidn()
    {
        $file = UploadedFile::fake()->image('sofia.jpg');

        $payload = [
            'nama_pengelola'    => 'Dr. Siti Rahma, M.Sc',
            'jenis_identitas'   => 'NIDN',
            'NIDN'              => '0612345678',
            'jabatan_pengelola' => 'Sekretaris P3M',
            'email_pengelola'   => 'siti.rahma@example.com',
            'image'             => $file,
        ];

        $response = $this->actingAs($this->admin)->post(route('pengelola.store'), $payload);

        $response->assertRedirect(route('pengelola.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('m__pengelolas', [
            'nama_pengelola'  => 'Dr. Siti Rahma, M.Sc',
            'jenis_identitas' => 'NIDN',
            'NIDN'            => '0612345678',
            'email_pengelola' => 'siti.rahma@example.com',
        ]);
    }

    public function test_admin_can_create_pengelola_with_nuptk()
    {
        $file = UploadedFile::fake()->image('staff.jpg');

        $payload = [
            'nama_pengelola'    => 'Agus Prasetyo, S.Kom',
            'jenis_identitas'   => 'NUPTK',
            'NIDN'              => '9876543210987654',
            'jabatan_pengelola' => 'Tenaga Ahli IT P3M',
            'email_pengelola'   => 'agus.p@example.com',
            'image'             => $file,
        ];

        $response = $this->actingAs($this->admin)->post(route('pengelola.store'), $payload);

        $response->assertRedirect(route('pengelola.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('m__pengelolas', [
            'nama_pengelola'  => 'Agus Prasetyo, S.Kom',
            'jenis_identitas' => 'NUPTK',
            'NIDN'            => '9876543210987654',
            'email_pengelola' => 'agus.p@example.com',
        ]);
    }

    public function test_validation_fails_when_jenis_identitas_is_invalid_or_missing()
    {
        $file = UploadedFile::fake()->image('staff.jpg');

        $payload = [
            'nama_pengelola'    => 'Valid Name',
            'jenis_identitas'   => 'INVALID_TYPE',
            'NIDN'              => '1234567890',
            'jabatan_pengelola' => 'Staff',
            'email_pengelola'   => 'staff@example.com',
            'image'             => $file,
        ];

        $response = $this->actingAs($this->admin)->post(route('pengelola.store'), $payload);
        $response->assertSessionHasErrors(['jenis_identitas']);
    }

    public function test_admin_can_update_pengelola_identity_type_and_number()
    {
        $pengelola = M_Pengelola::create([
            'nama_pengelola'    => 'Hendri Wijaya, M.T',
            'jenis_identitas'   => 'NIDN',
            'NIDN'              => '0622334455',
            'jabatan_pengelola' => 'Reviewer',
            'email_pengelola'   => 'hendri@example.com',
            'image'             => 'sample_h.webp',
        ]);

        $payload = [
            'nama_pengelola'    => 'Hendri Wijaya, M.T',
            'jenis_identitas'   => 'NUPTK',
            'NIDN'              => '9988776655443322',
            'jabatan_pengelola' => 'Reviewer Ahli',
            'email_pengelola'   => 'hendri@example.com',
        ];

        $response = $this->actingAs($this->admin)->put(route('pengelola.update', $pengelola->id), $payload);

        $response->assertRedirect(route('pengelola.index'));
        $response->assertSessionHas('success');

        $pengelola->refresh();
        $this->assertEquals('NUPTK', $pengelola->jenis_identitas);
        $this->assertEquals('9988776655443322', $pengelola->NIDN);
        $this->assertEquals('Reviewer Ahli', $pengelola->jabatan_pengelola);
    }

    public function test_search_can_find_pengelola_by_jenis_identitas()
    {
        M_Pengelola::create([
            'nama_pengelola'    => 'Dosen A',
            'jenis_identitas'   => 'NIDN',
            'NIDN'              => '1111111111',
            'jabatan_pengelola' => 'Staff',
            'email_pengelola'   => 'dosena@example.com',
            'image'             => 'a.webp',
        ]);

        M_Pengelola::create([
            'nama_pengelola'    => 'Tendik B',
            'jenis_identitas'   => 'NUPTK',
            'NIDN'              => '2222222222222222',
            'jabatan_pengelola' => 'Staff',
            'email_pengelola'   => 'tendikb@example.com',
            'image'             => 'b.webp',
        ]);

        $response = $this->actingAs($this->admin)->get(route('pengelola.index', ['search' => 'NUPTK']));
        $response->assertStatus(200);
        $response->assertSee('Tendik B');
    }
}
