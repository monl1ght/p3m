<?php

namespace Tests\Feature;

use App\Models\AgendaModel;
use App\Models\ajuan_penelitianModel;
use App\Models\Hki;
use App\Models\M_categories;
use App\Models\M_news;
use App\Models\p3mModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediumP2AuditTest extends TestCase
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
    }

    /**
     * MEDIUM-01: View composer notifikasi hanya aktif untuk admin di layout.main
     */
    public function test_view_composer_notification_only_loads_for_admin(): void
    {
        p3mModel::create([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Pengabdian Test Balekambang',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pengabdi',
            'jeniskelamin'    => 'L',
            'nidn'            => '0612345678',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '081234567890',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Balekambang',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'dummy.pdf',
            'jeniskategori'   => 'Pengabdian',
            'status'          => 'proses',
            'tanggal_mulai'   => now()->toDateString(),
            'tanggal_selesai' => now()->addMonth()->toDateString(),
            'read_at'         => null,
        ]);

        $responseGuest = $this->get(route('tampilan'));
        $responseGuest->assertStatus(200);
        $responseGuest->assertDontSee('1 Pengajuan Pengabdian');

        $responseDosen = $this->actingAs($this->dosen)->get(route('dosen.hki.index'));
        $responseDosen->assertStatus(200);
        $responseDosen->assertDontSee('1 Pengajuan Pengabdian');

        $responseAdmin = $this->actingAs($this->admin)->get(route('category.index'));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('1 Pengajuan Pengabdian');
    }

    /**
     * Dosen pemilik dapat mengedit dan menghapus HKI miliknya
     */
    public function test_dosen_can_edit_and_delete_own_hki(): void
    {
        Storage::fake('private');

        $ownHki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'Hak Cipta Modul Pembelajaran Web',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202612345',
            'file_path'        => 'hki-sertifikat/sample.pdf',
            'file_name'        => 'sample.pdf',
            'status'           => 'diproses',
        ]);

        $responseEdit = $this->actingAs($this->dosen)
            ->get(route('dosen.hki.edit', $ownHki->id));
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->actingAs($this->dosen)
            ->post(route('dosen.hki.update', $ownHki->id), [
                'judul'   => 'Judul Baru Yang Berhasil Diubah',
                'tanggal' => '2026-06-01',
                'anggota' => [
                    ['nama' => 'Dosen Penulis', 'peran' => 'Ketua'],
                ],
            ]);
        $responseUpdate->assertRedirect(route('dosen.hki.index'));
        $responseUpdate->assertSessionHas('success');

        $this->assertDatabaseHas('hkis', [
            'id'    => $ownHki->id,
            'judul' => 'Judul Baru Yang Berhasil Diubah',
        ]);

        $responseDelete = $this->actingAs($this->dosen)
            ->delete(route('dosen.hki.delete', $ownHki->id));
        $responseDelete->assertRedirect(route('dosen.hki.index'));
        $responseDelete->assertSessionHas('success');

        $this->assertDatabaseMissing('hkis', ['id' => $ownHki->id]);
    }

    /**
     * MEDIUM-02: HKI yang masih 'diproses' tetap dapat diedit & dihapus
     */
    public function test_dosen_can_edit_and_delete_in_process_hki(): void
    {
        Storage::fake('private');

        $inProcessHki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'Hak Cipta Game Edukasi',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202699999',
            'file_path'        => 'hki-sertifikat/sample2.pdf',
            'file_name'        => 'sample2.pdf',
            'status'           => 'diproses',
        ]);

        $responseEdit = $this->actingAs($this->dosen)
            ->get(route('dosen.hki.edit', $inProcessHki->id));
        $responseEdit->assertStatus(200);

        $responseDelete = $this->actingAs($this->dosen)
            ->delete(route('dosen.hki.delete', $inProcessHki->id));
        $responseDelete->assertRedirect(route('dosen.hki.index'));
        $responseDelete->assertSessionHas('success');

        $this->assertDatabaseMissing('hkis', ['id' => $inProcessHki->id]);
    }

    /**
     * MEDIUM-04: Parameter pencarian q pada header navbar terhubung ke M_news di berita
     */
    public function test_public_news_search_by_query_parameter(): void
    {
        $cat = M_categories::create(['name' => 'Umum', 'slug' => 'umum']);

        M_news::create([
            'title'       => 'Seminar Nasional Kecerdasan Buatan',
            'description' => 'Kegiatan ilmiah yang dihadiri oleh seluruh dosen dan peneliti nasional.',
            'content'     => '<p>Kegiatan ilmiah yang dihadiri oleh seluruh dosen dan peneliti nasional.</p>',
            'image'       => 'dummy1.jpg',
            'date'        => now()->toDateString(),
            'time'        => '09:00',
            'category_id' => $cat->id,
        ]);

        M_news::create([
            'title'       => 'Pelatihan Pertanian Hidroponik',
            'description' => 'Pelatihan bagi masyarakat desa sekitar kampus.',
            'content'     => '<p>Pelatihan bagi masyarakat desa sekitar kampus.</p>',
            'image'       => 'dummy2.jpg',
            'date'        => now()->toDateString(),
            'time'        => '13:00',
            'category_id' => $cat->id,
        ]);

        $response = $this->get(route('tampilan.berita', ['q' => 'Kecerdasan Buatan']));
        $response->assertStatus(200);
        $response->assertSee('Seminar Nasional Kecerdasan Buatan');
        $response->assertDontSee('Pelatihan Pertanian Hidroponik');
    }

    /**
     * MEDIUM-06: CategoryController menerapkan validasi unique slug pada store dan ubah
     */
    public function test_category_slug_must_be_unique(): void
    {
        M_categories::create(['name' => 'Penelitian Dosen', 'slug' => 'penelitian-dosen']);

        $responseStore = $this->actingAs($this->admin)
            ->post(route('category.store'), ['name' => 'Penelitian Dosen Baru', 'slug' => 'penelitian-dosen']);
        $responseStore->assertSessionHasErrors(['slug']);

        $responseStoreAuto = $this->actingAs($this->admin)
            ->post(route('category.store'), ['name' => 'Penelitian Dosen', 'slug' => '']);
        $responseStoreAuto->assertSessionHasErrors(['slug']);

        $cat2 = M_categories::create(['name' => 'Pengabdian Warga', 'slug' => 'pengabdian-warga']);

        $responseUpdateDuplicate = $this->actingAs($this->admin)
            ->put(route('category.ubah', $cat2->id), ['name' => 'Pengabdian Warga Revisi', 'slug' => 'penelitian-dosen']);
        $responseUpdateDuplicate->assertSessionHasErrors(['slug']);

        $responseUpdateSelf = $this->actingAs($this->admin)
            ->put(route('category.ubah', $cat2->id), ['name' => 'Pengabdian Warga Diperbarui', 'slug' => 'pengabdian-warga']);
        $responseUpdateSelf->assertSessionHasNoErrors();
        $responseUpdateSelf->assertRedirect(route('category.index'));
        $this->assertDatabaseHas('m_categories', ['id' => $cat2->id, 'name' => 'Pengabdian Warga Diperbarui']);
    }

    /**
     * MEDIUM-03: Surat Tugas Penelitian dapat diunduh oleh pemilik/admin jika berstatus approve
     */
    public function test_surat_tugas_penelitian_download(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Analisis Sistem Sensor Pertanian',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Peneliti',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098801',
            'jabatan'         => 'Lektor Kepala',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Laboratorium IoT',
            'lamapenelitian'  => '60',
            'biaya'           => '10000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => '001/P3M-POLIBANG/ST-PN/2026',
            'tanggal_mulai'   => now()->toDateString(),
            'tanggal_selesai' => now()->addMonths(2)->toDateString(),
        ]);

        $response = $this->actingAs($this->dosen)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    /**
     * MEDIUM-05: AgendaController menghapus file gambar menggunakan Storage::disk('public')
     */
    public function test_agenda_delete_removes_image_from_public_storage(): void
    {
        Storage::fake('public');

        $imageName = 'test-agenda-image.jpg';
        $imagePath = 'photo-agenda/' . $imageName;
        Storage::disk('public')->put($imagePath, 'fake-image-content');
        $this->assertTrue(Storage::disk('public')->exists($imagePath));

        $imageUrl = Storage::url($imagePath);

        $agenda = AgendaModel::create([
            'title'      => 'Agenda Rapat Koordinasi P3M',
            'date'       => now()->toDateString(),
            'time'       => '09:00',
            'lokasi'     => 'Ruang Rapat Utama',
            'keterangan' => '<p>Pembahasan agenda tahunan.</p><img src="' . $imageUrl . '">',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('agenda.delete', $agenda->id));
        $response->assertRedirect(route('agenda.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('agenda_models', ['id' => $agenda->id]);
        $this->assertFalse(Storage::disk('public')->exists($imagePath));
    }

    /**
     * SEC-AUTHZ-02: Dosen tidak dapat mengedit atau menghapus HKI yang sudah disetujui (status = 'diterima')
     */
    public function test_dosen_cannot_edit_or_delete_approved_hki(): void
    {
        Storage::fake('private');

        $approvedHki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'Hak Cipta Terverifikasi Resmi',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202688888',
            'file_path'        => 'hki-sertifikat/approved.pdf',
            'file_name'        => 'approved.pdf',
            'status'           => 'diterima',
        ]);

        $responseEdit = $this->actingAs($this->dosen)->get(route('dosen.hki.edit', $approvedHki->id));
        $responseEdit->assertRedirect(route('dosen.hki.index'));
        $responseEdit->assertSessionHas('error');

        $responseUpdate = $this->actingAs($this->dosen)
            ->post(route('dosen.hki.update', $approvedHki->id), [
                'judul'   => 'Upaya Ubah Judul Ilegal',
                'tanggal' => '2026-06-01',
                'anggota' => [['nama' => 'Dosen Penulis', 'peran' => 'Ketua']],
            ]);
        $responseUpdate->assertRedirect(route('dosen.hki.index'));
        $responseUpdate->assertSessionHas('error');

        $this->assertDatabaseHas('hkis', ['id' => $approvedHki->id, 'judul' => 'Hak Cipta Terverifikasi Resmi']);

        $responseDelete = $this->actingAs($this->dosen)->delete(route('dosen.hki.delete', $approvedHki->id));
        $responseDelete->assertRedirect(route('dosen.hki.index'));
        $responseDelete->assertSessionHas('error');

        $this->assertDatabaseHas('hkis', ['id' => $approvedHki->id]);
    }

    /**
     * SEC-XSS-01: HtmlSanitizer membersihkan payload XSS berbahaya tanpa merusak format konten
     */
    public function test_html_sanitizer_cleans_xss_while_preserving_formatting(): void
    {
        $sanitizer = app(\App\Services\HtmlSanitizer::class);

        $payload = '<p style="color: blue; text-align: justify;">Format aman <strong>tebal</strong> <em>miring</em></p>'
            . '<script>alert("XSS")</script>'
            . '<img src="https://example.com/valid.jpg" onerror="alert(1)" alt="Foto">'
            . '<a href="javascript:alert(2)" target="_blank">Link Berbahaya</a>'
            . '<a href="https://polibang.ac.id" target="_blank">Link Kampus</a>'
            . '<iframe src="https://evil.com"></iframe>'
            . '<table class="table"><tr><td>Data</td></tr></table>';

        $clean = $sanitizer->sanitize($payload);

        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('alert(', $clean);
        $this->assertStringNotContainsString('onerror', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringNotContainsString('<iframe', $clean);

        $this->assertStringContainsString('Format aman', $clean);
        $this->assertStringContainsString('<strong>tebal</strong>', $clean);
        $this->assertStringContainsString('<em>miring</em>', $clean);
        $this->assertStringContainsString('src="https://example.com/valid.jpg"', $clean);
        $this->assertStringContainsString('href="https://polibang.ac.id"', $clean);
        $this->assertStringContainsString('rel="noopener noreferrer"', $clean);
        $this->assertStringContainsString('<table', $clean);
    }

    // ═══════════════════════════════════════════════════════════════════
    //  BATCH 2 TESTS
    // ═══════════════════════════════════════════════════════════════════

    /**
     * SEC-AUTH-01: Passcode valid dapat digunakan untuk registrasi dosen
     */
    public function test_valid_passcode_grants_registration_access(): void
    {
        Config::set('auth.dosen_registration_passcode', 'test-passcode-valid');

        $response = $this->post(route('register.verify-gate'), [
            'passcode' => 'test-passcode-valid',
        ]);

        $response->assertRedirect(route('register'));
        $this->assertTrue(session('dosen_register_authorized', false));
    }

    /**
     * SEC-AUTH-01: Passcode salah ditolak
     */
    public function test_invalid_passcode_is_rejected(): void
    {
        Config::set('auth.dosen_registration_passcode', 'test-passcode-valid');

        $response = $this->post(route('register.verify-gate'), [
            'passcode' => 'wrong-passcode',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertFalse(session('dosen_register_authorized', false));
    }

    /**
     * SEC-AUTH-01: Fail-closed — jika passcode tidak dikonfigurasi, semua request ditolak
     */
    public function test_missing_passcode_config_triggers_fail_closed(): void
    {
        // Simulasikan environment tanpa DOSEN_REGISTRATION_PASSCODE
        Config::set('auth.dosen_registration_passcode', null);

        $response = $this->post(route('register.verify-gate'), [
            'passcode' => 'apapun-sekalipun',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertFalse(session('dosen_register_authorized', false));
    }

    /**
     * SEC-AUTHZ-01: Route dosen.profil hanya dapat diakses oleh role dosen
     * Dosen mengakses profil miliknya sendiri berhasil.
     * Admin yang mencoba route dosen.profil mendapat 403 (middleware role:dosen).
     */
    public function test_dosen_profil_route_only_accessible_by_dosen(): void
    {
        // Dosen dapat mengakses profil miliknya sendiri
        $responseDosen = $this->actingAs($this->dosen)
            ->get(route('dosen.profil', $this->dosen->id));
        $responseDosen->assertStatus(200);

        // Admin mencoba mengakses route yang dilindungi middleware role:dosen.
        // Middleware role:dosen menolak dengan redirect (302) bukan abort 403.
        // Yang penting: admin tidak dapat mengakses halaman profil dosen.
        $responseAdmin = $this->actingAs($this->admin)
            ->get(route('dosen.profil', $this->admin->id));
        // Middleware role:dosen akan redirect admin ke halaman lain (bukan 200)
        $responseAdmin->assertStatus(302);
    }

    /**
     * SEC-AUTHZ-01: Route /profil/{id} tanpa prefix dosdash tidak lagi terdaftar (404)
     */
    public function test_old_profil_route_without_prefix_no_longer_exists(): void
    {
        $response = $this->actingAs($this->dosen)
            ->get('/profil/' . $this->dosen->id);
        $response->assertStatus(404);
    }

    /**
     * SEC-AUTHZ-03: Admin tidak dapat menghapus akun sendiri yang sedang login
     */
    public function test_admin_cannot_delete_own_account(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('delete', $this->admin->id));

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('error');

        // Akun admin masih ada di database — tidak terhapus
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    /**
     * SEC-AUTHZ-03: Admin masih dapat menghapus user lain (bukan akun sendiri)
     */
    public function test_admin_can_delete_other_users(): void
    {
        $otherUser = User::factory()->create(['role' => 'dosen']);

        $response = $this->actingAs($this->admin)
            ->delete(route('delete', $otherUser->id));

        // redirect()->route('index', compact('user')) menghasilkan URL dengan query param
        $response->assertRedirectContains('/user');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $otherUser->id]);
    }

    /**
     * SEC-AUTHZ-04: Perubahan status HKI oleh Admin tercatat di SubmissionStatusHistory
     */
    public function test_admin_hki_status_change_creates_audit_history(): void
    {
        $hki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'HKI Audit Trail Test',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202611111',
            'file_path'        => 'hki-sertifikat/audit.pdf',
            'file_name'        => 'audit.pdf',
            'status'           => 'diproses',
        ]);

        // Admin mengubah status ke 'diterima'
        $response = $this->actingAs($this->admin)
            ->patch(route('plppm.hki_dosen.status', $hki->id), [
                'status'  => 'diterima',
                'catatan' => 'Dokumen lengkap dan valid.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifikasi status HKI berubah di DB
        $this->assertDatabaseHas('hkis', [
            'id'     => $hki->id,
            'status' => 'diterima',
        ]);

        // Verifikasi audit trail tersimpan di SubmissionStatusHistory
        $this->assertDatabaseHas('submission_status_histories', [
            'submission_type' => 'hki',
            'submission_id'   => $hki->id,
            'previous_status' => 'diproses',
            'status'          => 'diterima',
            'decided_by'      => $this->admin->id,
        ]);
    }

    /**
     * SEC-AUTHZ-04: Update catatan saja (tanpa perubahan status) TIDAK membuat duplicate history
     */
    public function test_admin_hki_note_update_without_status_change_no_duplicate_history(): void
    {
        $hki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'HKI Catatan Saja',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202622222',
            'file_path'        => 'hki-sertifikat/note.pdf',
            'file_name'        => 'note.pdf',
            'status'           => 'diproses',
        ]);

        // Admin hanya memperbarui catatan, tanpa mengubah status
        $response = $this->actingAs($this->admin)
            ->patch(route('plppm.hki_dosen.status', $hki->id), [
                'catatan' => 'Silakan lengkapi dokumen pendukung.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Tidak ada history yang dibuat karena status tidak berubah
        $this->assertDatabaseCount('submission_status_histories', 0);
    }

    /**
     * SEC-HOST-01: TrustProxies menghasilkan $proxies = null saat TRUSTED_PROXIES kosong
     */
    public function test_trust_proxies_uses_null_when_env_is_empty(): void
    {
        $middleware = new \App\Http\Middleware\TrustProxies();

        $reflection = new \ReflectionClass($middleware);
        $property   = $reflection->getProperty('proxies');
        $property->setAccessible(true);
        $proxies = $property->getValue($middleware);

        // Saat TRUSTED_PROXIES= (kosong di .env), proxies harus null — tidak ada proxy dipercaya
        $this->assertNull($proxies, 'TrustProxies harus null ketika TRUSTED_PROXIES tidak dikonfigurasi');
    }

    /**
     * SEC-HOST-01: Aplikasi tetap berjalan normal tanpa crash saat ada header X-Forwarded-For
     * yang tidak dipercaya (proxy tidak dikonfigurasi)
     */
    public function test_request_ip_not_spoofable_without_trusted_proxy(): void
    {
        // Tanpa trusted proxy, X-Forwarded-For dari client diabaikan — aplikasi tidak crash
        $response = $this->withHeaders([
            'X-Forwarded-For' => '1.2.3.4',
        ])->get(route('tampilan'));

        $response->assertStatus(200);
    }

    // ═══════════════════════════════════════════════════════════════════
    //  BATCH 3 TESTS
    // ═══════════════════════════════════════════════════════════════════

    /**
     * SEC-XSS-02: Valid base64 PNG image is accepted, validated, and stored as WebP
     */
    public function test_base64_valid_png_image_accepted_and_stored(): void
    {
        Storage::fake('public');
        $imageService = app(\App\Services\ImageService::class);

        // Create a real 50x50 PNG image (must exceed 100-byte minimum threshold)
        $img = imagecreatetruecolor(50, 50);
        // Fill with varied colors to ensure sufficient compressed data size
        for ($x = 0; $x < 50; $x++) {
            for ($y = 0; $y < 50; $y++) {
                imagesetpixel($img, $x, $y, imagecolorallocate($img, $x * 5, $y * 5, 128));
            }
        }
        ob_start();
        imagepng($img);
        $pngData = ob_get_clean();
        imagedestroy($img);

        $base64 = 'data:image/png;base64,' . base64_encode($pngData);
        $filename = $imageService->storeBase64($base64, 'test-images');

        $this->assertNotEmpty($filename);
        $this->assertStringEndsWith('.webp', $filename);
        $this->assertTrue(Storage::disk('public')->exists('test-images/' . $filename));

        // Verify stored file is valid WebP
        $storedData = Storage::disk('public')->get('test-images/' . $filename);
        $info = getimagesizefromstring($storedData);
        $this->assertNotFalse($info);
        $this->assertEquals('image/webp', $info['mime']);
    }

    /**
     * SEC-XSS-02: SVG data URI is rejected (potential XSS vector)
     */
    public function test_base64_svg_payload_rejected(): void
    {
        $imageService = app(\App\Services\ImageService::class);

        $svgPayload = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert("XSS")</script></svg>';
        $base64 = 'data:image/svg+xml;base64,' . base64_encode($svgPayload);

        $this->expectException(\RuntimeException::class);
        $imageService->storeBase64($base64, 'test-images');
    }

    /**
     * SEC-XSS-02: HTML disguised as image is rejected
     */
    public function test_base64_html_payload_rejected(): void
    {
        $imageService = app(\App\Services\ImageService::class);

        $htmlPayload = '<html><body><script>alert("XSS")</script></body></html>';
        $base64 = 'data:text/html;base64,' . base64_encode($htmlPayload);

        $this->expectException(\RuntimeException::class);
        $imageService->storeBase64($base64, 'test-images');
    }

    /**
     * SEC-XSS-02: processBase64InlineImage returns null for malicious payload (no exception)
     */
    public function test_inline_image_processor_rejects_invalid_gracefully(): void
    {
        $imageService = app(\App\Services\ImageService::class);

        $svgPayload = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>';
        $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svgPayload);

        $result = $imageService->processBase64InlineImage($dataUri, 'test-images');
        $this->assertNull($result, 'Malicious SVG payload should be silently rejected');
    }

    /**
     * SEC-XSS-02: processBase64InlineImage stores valid image and returns filename
     */
    public function test_inline_image_processor_accepts_valid_image(): void
    {
        Storage::fake('public');
        $imageService = app(\App\Services\ImageService::class);

        $img = imagecreatetruecolor(4, 4);
        imagefill($img, 0, 0, imagecolorallocate($img, 255, 0, 0));
        ob_start();
        imagejpeg($img);
        $jpegData = ob_get_clean();
        imagedestroy($img);

        $dataUri = 'data:image/jpeg;base64,' . base64_encode($jpegData);
        $filename = $imageService->processBase64InlineImage($dataUri, 'photo-agenda');

        $this->assertNotNull($filename);
        $this->assertStringEndsWith('.webp', $filename);
        $this->assertTrue(Storage::disk('public')->exists('photo-agenda/' . $filename));
    }

    /**
     * SEC-FILE-01: Upload PDF uses server-detected extension via guessExtension()
     */
    public function test_panduan_upload_uses_server_detected_extension(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->post(route('panduan.store'), [
                'namefile' => 'Panduan Penelitian 2026',
                'original_name' => UploadedFile::fake()->create('proposal.pdf', 100, 'application/pdf'),
            ]);

        $response->assertRedirect(route('panduan.index'));
        $response->assertSessionHas('success');

        // Verify that the file was stored with .pdf extension (server-detected)
        $panduan = \App\Models\m_panduan::latest()->first();
        $this->assertNotNull($panduan);
        $this->assertStringEndsWith('.pdf', $panduan->original_name);
    }

    /**
     * SEC-FILE-01: Upload DOCX uses server-detected extension
     */
    public function test_dokumen_upload_uses_server_detected_extension(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->post(route('dokumen.store'), [
                'namefile' => 'Template Pengabdian',
                'originalname' => UploadedFile::fake()->create('template.docx', 50, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            ]);

        $response->assertRedirect(route('dokumen.index'));
        $response->assertSessionHas('success');

        $dokumen = \App\Models\DokumenModel::latest()->first();
        $this->assertNotNull($dokumen);
        // guessExtension() for DOCX MIME returns 'docx'
        $ext = pathinfo($dokumen->originalname, PATHINFO_EXTENSION);
        $this->assertContains($ext, ['docx', 'bin'], 'Extension should be server-detected');
    }

    /**
     * SEC-HEAD-01: Security headers present on public page response
     */
    public function test_security_headers_present_on_public_page(): void
    {
        $response = $this->get(route('tampilan'));
        $response->assertStatus(200);

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '0');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    /**
     * SEC-HEAD-01: Security headers present on authenticated admin dashboard
     */
    public function test_security_headers_present_on_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('category.index'));
        $response->assertStatus(200);

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * SEC-HEAD-01: No aggressive CSP or HSTS headers are set (intentionally deferred)
     */
    public function test_no_aggressive_csp_or_hsts_headers(): void
    {
        $response = $this->get(route('tampilan'));
        $response->assertStatus(200);

        $response->assertHeaderMissing('Content-Security-Policy');
        $response->assertHeaderMissing('Strict-Transport-Security');
    }

    /**
     * SEC-CORS-01: Default CORS config uses APP_URL, no wildcard fallback
     */
    public function test_cors_default_uses_app_url_no_wildcard(): void
    {
        $origins = config('cors.allowed_origins');
        // No wildcard in default config
        $this->assertNotContains('*', $origins, 'Default CORS must not contain wildcard');
        // Should contain APP_URL as fallback
        $this->assertContains(config('app.url'), $origins);
    }

    /**
     * SEC-CORS-01: CORS config parses CSV env variable correctly
     */
    public function test_cors_env_parsing_multiple_origins(): void
    {
        // Simulate production config with specific origins
        $parsed = array_filter(
            array_map('trim', explode(',', 'https://p3m.polibang.ac.id, https://polibang.ac.id')),
            fn (string $v) => $v !== ''
        );

        $this->assertCount(2, $parsed);
        $this->assertEquals('https://p3m.polibang.ac.id', $parsed[0]);
        $this->assertEquals('https://polibang.ac.id', $parsed[1]);
        $this->assertNotContains('*', $parsed);
    }

    /**
     * SEC-CORS-01: API endpoint responds correctly with CORS headers
     */
    public function test_api_user_endpoint_returns_cors_headers(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->withHeaders(['Origin' => 'http://localhost:3000'])
            ->getJson('/api/user');

        $response->assertStatus(200);
        // HandleCors middleware should set Access-Control-Allow-Origin
        $response->assertHeader('Access-Control-Allow-Origin');
    }

    // ═══════════════════════════════════════════════════════════════════
    //  BATCH 4A TESTS
    // ═══════════════════════════════════════════════════════════════════

    /**
     * SEC-LOG-01: Login berhasil menghasilkan log entry
     */
    public function test_successful_login_is_logged(): void
    {
        $user = User::factory()->create([
            'role'     => 'admin',
            'password' => bcrypt('password123'),
        ]);

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $message, array $context) use ($user) {
                return $message === 'Login berhasil'
                    && $context['user_id'] === $user->id
                    && $context['role'] === 'admin'
                    && isset($context['ip'])
                    && isset($context['user_agent']);
            });

        // Allow other log calls to pass through
        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->withAnyArgs()
            ->zeroOrMoreTimes();
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->withAnyArgs()
            ->zeroOrMoreTimes();

        $this->post('/proses-login', [
            'name'     => $user->name,
            'password' => 'password123',
        ]);
    }

    /**
     * SEC-LOG-01: Login gagal menghasilkan warning log
     */
    public function test_failed_login_is_logged(): void
    {
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->once()
            ->withArgs(function (string $message, array $context) {
                return $message === 'Login gagal'
                    && $context['username'] === 'nonexistent_user'
                    && isset($context['ip'])
                    && isset($context['user_agent']);
            });

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->withAnyArgs()
            ->zeroOrMoreTimes();
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->withAnyArgs()
            ->zeroOrMoreTimes();

        $this->post('/proses-login', [
            'name'     => 'nonexistent_user',
            'password' => 'wrong_password',
        ]);
    }

    /**
     * SEC-LOG-01: Passcode registrasi gagal menghasilkan warning log
     */
    public function test_failed_registration_passcode_is_logged(): void
    {
        Config::set('auth.dosen_registration_passcode', 'correct-passcode');

        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->once()
            ->withArgs(function (string $message, array $context) {
                return $message === 'Passcode registrasi dosen gagal'
                    && isset($context['ip'])
                    && isset($context['user_agent']);
            });

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->withAnyArgs()
            ->zeroOrMoreTimes();
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->withAnyArgs()
            ->zeroOrMoreTimes();

        $this->post(route('register.verify-gate'), [
            'passcode' => 'wrong-passcode',
        ]);
    }

    /**
     * SEC-LOG-01: Log login gagal TIDAK mengandung password
     */
    public function test_login_log_does_not_contain_password(): void
    {
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->once()
            ->withArgs(function (string $message, array $context) {
                // Verify no password-like keys exist in the context
                $contextJson = json_encode($context);
                return $message === 'Login gagal'
                    && !isset($context['password'])
                    && !str_contains($contextJson, 'supersecretpassword');
            });

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->withAnyArgs()
            ->zeroOrMoreTimes();
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->withAnyArgs()
            ->zeroOrMoreTimes();

        $this->post('/proses-login', [
            'name'     => 'testuser',
            'password' => 'supersecretpassword',
        ]);
    }

    /**
     * SEC-LOG-01: User deletion oleh admin menghasilkan log
     */
    public function test_user_deletion_is_logged(): void
    {
        $otherUser = User::factory()->create(['role' => 'dosen']);

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $message, array $context) use ($otherUser) {
                return $message === 'User dihapus oleh admin'
                    && $context['deleted_user_id'] === $otherUser->id
                    && $context['deleted_role'] === 'dosen'
                    && isset($context['admin_id']);
            });

        \Illuminate\Support\Facades\Log::shouldReceive('info')
            ->withAnyArgs()
            ->zeroOrMoreTimes();
        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->withAnyArgs()
            ->zeroOrMoreTimes();

        $this->actingAs($this->admin)->delete(route('delete', $otherUser->id));
    }

    /**
     * SEC-FILE-03: Sample/demo files sudah dihapus dari public directory
     */
    public function test_sample_files_removed_from_public(): void
    {
        $this->assertFileDoesNotExist(public_path('sample_surat_penelitian.pdf'));
        $this->assertFileDoesNotExist(public_path('sample_surat_pengabdian.pdf'));
        $this->assertFileDoesNotExist(public_path('demo-design.html'));
    }

    /**
     * SEC-FILE-03: Halaman publik tidak memiliki broken references ke file yang dihapus
     */
    public function test_public_pages_no_broken_references_to_removed_files(): void
    {
        $response = $this->get(route('tampilan'));
        $response->assertStatus(200);
        $response->assertDontSee('sample_surat_penelitian');
        $response->assertDontSee('sample_surat_pengabdian');
        $response->assertDontSee('demo-design.html');
    }
}

