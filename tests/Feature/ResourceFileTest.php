<?php

namespace Tests\Feature;

use App\Models\ResourceFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResourceFileTest extends TestCase
{
    use RefreshDatabase;

    private const PDF_BYTES = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF\n";

    private const PNG_BASE64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    /** @var list<string> */
    private array $tempFiles = [];

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');
    }

    protected function tearDown(): void
    {
        foreach ($this->tempFiles as $path) {
            @unlink($path);
        }

        parent::tearDown();
    }

    public function test_guest_download_redirects_to_login(): void
    {
        $file = $this->storedFile();

        $this->get(route('resources.download', $file))->assertRedirect(route('login'));
        $this->assertSame(0, $file->fresh()->download_count);
    }

    public function test_guest_opening_download_link_returns_to_list_after_login(): void
    {
        // 공유받은 받기 주소를 바로 열어도 로그인 뒤 파일 응답 화면에 갇히지 않고 목록으로 온다.
        $file = $this->storedFile();
        $member = $this->member();

        $this->get(route('resources.download', $file))->assertRedirect(route('login'));
        $this->post('/login', ['email' => $member->email, 'password' => 'password'])
            ->assertRedirect(route('resources.index'));
    }

    public function test_member_downloads_attachment_with_original_korean_name(): void
    {
        $file = $this->storedFile(['original_name' => '제이커브 소개서 2026.pdf']);

        $response = $this->actingAs($this->member())->get(route('resources.download', $file));

        $response->assertOk();
        $disposition = (string) $response->headers->get('Content-Disposition');
        $this->assertStringStartsWith('attachment;', $disposition);
        $this->assertStringContainsString("filename*=utf-8''".rawurlencode('제이커브 소개서 2026.pdf'), $disposition);
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('noindex', (string) $response->headers->get('X-Robots-Tag'));
        $this->assertSame(self::PDF_BYTES, $response->streamedContent());
        $this->assertSame(1, $file->fresh()->download_count);

        $this->actingAs($this->member())->call('HEAD', route('resources.download', $file))->assertOk();
        $this->assertSame(1, $file->fresh()->download_count);
    }

    public function test_member_cannot_upload_or_open_admin_screen(): void
    {
        $member = $this->member();

        $this->actingAs($member)->get(route('admin.resources.index'))->assertForbidden();
        $this->actingAs($member)->post(route('admin.resources.store'), [
            'title' => '회원 업로드',
            'file' => UploadedFile::fake()->create('member.pdf', 10, 'application/pdf'),
        ])->assertForbidden();
        $this->actingAs($member)->delete(route('admin.resources.destroy', $this->storedFile()))->assertForbidden();
        $this->actingAs($member)->delete('/admin/resources/999999')->assertForbidden();

        $this->assertSame(1, ResourceFile::count());
        $this->assertCount(1, Storage::disk('local')->allFiles('resources'));
    }

    public function test_guest_upload_redirects_to_login(): void
    {
        $this->get(route('admin.resources.index'))->assertRedirect(route('login'));
        $this->post(route('admin.resources.store'), [
            'title' => '비회원 업로드',
            'file' => UploadedFile::fake()->create('guest.pdf', 10, 'application/pdf'),
        ])->assertRedirect(route('login'));

        $this->assertSame(0, ResourceFile::count());
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_admin_upload_stores_random_name_on_private_disk_and_keeps_original_name(): void
    {
        $admin = $this->admin();
        $upload = $this->realUpload(self::PDF_BYTES, '2026 마케팅 리포트.pdf');

        $this->actingAs($admin)->get(route('admin.resources.index'))->assertOk()->assertSee('20MB 이하 PDF');

        $this->actingAs($admin)->post(route('admin.resources.store'), [
            'title' => '2026 마케팅 리포트',
            'description' => '분기별 정리',
            'file' => $upload,
        ])->assertRedirect(route('admin.resources.index'))->assertSessionHas('status', 'resource-uploaded');

        $file = ResourceFile::sole();
        $this->assertMatchesRegularExpression('#^resources/[A-Za-z0-9]{40}\.pdf$#', $file->path);
        $this->assertStringNotContainsString('마케팅', $file->path);
        Storage::disk('local')->assertExists($file->path);
        $this->assertSame(self::PDF_BYTES, Storage::disk('local')->get($file->path));
        $this->assertFalse(Storage::disk('public')->exists($file->path));
        $this->assertSame('2026 마케팅 리포트.pdf', $file->original_name);
        $this->assertSame('application/pdf', $file->mime);
        $this->assertSame(strlen(self::PDF_BYTES), $file->size);
        $this->assertSame($admin->id, $file->uploaded_by);
        $this->assertTrue($file->is_published);
        $this->assertSame(0, $file->download_count);
    }

    public function test_png_renamed_to_pdf_is_rejected(): void
    {
        $admin = $this->admin();
        $disguised = [
            'png' => base64_decode(self::PNG_BASE64),
            'html' => "<!DOCTYPE html>\n<html><body><script>alert(1)</script></body></html>\n",
            'php' => "<?php echo 'x'; ?>\n",
        ];

        foreach ($disguised as $kind => $bytes) {
            $this->actingAs($admin)->from(route('admin.resources.index'))->post(route('admin.resources.store'), [
                'title' => '가짜 PDF '.$kind,
                'file' => $this->realUpload($bytes, 'disguised.pdf'),
            ])->assertRedirect(route('admin.resources.index'))->assertSessionHasErrors(['file' => 'PDF 파일만 올릴 수 있습니다.']);
        }

        $this->assertSame(0, ResourceFile::count());
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_size_limit_is_exactly_20480_kilobytes(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.resources.store'), [
            'title' => '너무 큰 자료',
            'file' => UploadedFile::fake()->create('big.pdf', 20481, 'application/pdf'),
        ])->assertSessionHasErrors(['file' => '20MB(20,480KB) 이하 파일만 올릴 수 있습니다.']);
        $this->assertSame(0, ResourceFile::count());

        $this->actingAs($admin)->post(route('admin.resources.store'), [
            'title' => '딱 20MB 자료',
            'file' => UploadedFile::fake()->create('limit.pdf', 20480, 'application/pdf'),
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.resources.index'));

        $this->assertSame(20480 * 1024, ResourceFile::sole()->size);
    }

    public function test_upload_validation_messages_are_korean(): void
    {
        $this->actingAs($this->admin())->post(route('admin.resources.store'), [
            'title' => str_repeat('가', 201),
        ])->assertSessionHasErrors([
            'title' => '제목은 200자 이하로 입력해 주세요.',
            'file' => '올릴 PDF 파일을 골라 주세요.',
        ]);
    }

    public function test_path_characters_in_original_name_do_not_break_download(): void
    {
        $member = $this->member();

        foreach (['../../etc/passwd.pdf', '..\\..\\windows\\보고서.pdf', "a/b\\c\x00\x1f.pdf", '/', ''] as $name) {
            // 정리 전 값이 DB 에 들어간 경우(옛 데이터·직접 입력)도 500 없이 받아져야 한다.
            $file = $this->storedFile(['original_name' => $name]);

            $response = $this->actingAs($member)->get(route('resources.download', $file));

            $response->assertOk();
            $disposition = (string) $response->headers->get('Content-Disposition');
            $this->assertStringStartsWith('attachment;', $disposition);
            $this->assertStringNotContainsString('/', rawurldecode($disposition), $name);
            $this->assertStringNotContainsString('\\', rawurldecode($disposition), $name);
        }

        // 업로드 때도 같은 규칙으로 정리해서 저장한다.
        $upload = UploadedFile::fake()->create("..\\..\\evil\x07.pdf", 5, 'application/pdf');
        $this->actingAs($this->admin())->post(route('admin.resources.store'), ['title' => '이름 정리', 'file' => $upload])
            ->assertSessionHasNoErrors();
        $stored = ResourceFile::where('title', '이름 정리')->sole();
        $this->assertSame('evil.pdf', $stored->original_name);
        $this->actingAs($member)->get(route('resources.download', $stored))->assertOk();
    }

    public function test_clean_original_name_rules(): void
    {
        $this->assertSame('보고서.pdf', ResourceFile::cleanOriginalName('보고서'));
        $this->assertSame('A.PDF', ResourceFile::cleanOriginalName('A.PDF'));
        $this->assertSame('....xyz.pdf', ResourceFile::cleanOriginalName('../../x/y\\z.pdf'));
        $this->assertSame('자료.pdf', ResourceFile::cleanOriginalName(''));
        $this->assertSame('자료.pdf', ResourceFile::cleanOriginalName("/\\\x00 "));
        $this->assertSame('자료.pdf', ResourceFile::cleanOriginalName('.pdf'));
        $this->assertSame('evilfdp.exe.pdf', ResourceFile::cleanOriginalName("evil\u{202E}fdp.exe"));

        $long = ResourceFile::cleanOriginalName(str_repeat('가', 300).'.pdf');
        $this->assertSame(255, mb_strlen($long));
        $this->assertStringEndsWith('.pdf', $long);

        $longWithoutExtension = ResourceFile::cleanOriginalName(str_repeat('나', 300));
        $this->assertSame(255, mb_strlen($longWithoutExtension));
        $this->assertStringEndsWith('.pdf', $longWithoutExtension);
    }

    public function test_unpublished_and_missing_files_return_404(): void
    {
        $member = $this->member();

        $hidden = $this->storedFile(['is_published' => false]);
        $this->actingAs($member)->get(route('resources.download', $hidden))->assertNotFound();

        $missing = $this->storedFile();
        Storage::disk('local')->delete($missing->path);
        $this->actingAs($member)->get(route('resources.download', $missing))->assertNotFound();

        $this->actingAs($member)->get('/resources/999999/download')->assertNotFound();
        $this->assertSame(0, $hidden->fresh()->download_count);
        $this->assertSame(0, $missing->fresh()->download_count);
    }

    public function test_registration_ignores_role_admin(): void
    {
        $this->post('/register', [
            'name' => '가입자',
            'email' => 'joiner@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ])->assertSessionHasNoErrors();

        $this->assertAuthenticated();
        $this->assertSame('member', User::where('email', 'joiner@example.com')->value('role'));
        $this->get(route('admin.resources.index'))->assertForbidden();
    }

    public function test_stored_file_is_not_served_from_storage_url_without_signature(): void
    {
        $file = $this->storedFile();

        $response = $this->get('/storage/'.$file->path);

        $this->assertContains($response->status(), [403, 404]);
        $this->assertStringNotContainsString('%PDF', (string) $response->getContent());
    }

    public function test_admin_delete_removes_row_and_file(): void
    {
        $file = $this->storedFile();
        $other = $this->storedFile();

        $this->actingAs($this->admin())->delete(route('admin.resources.destroy', $file))
            ->assertRedirect(route('admin.resources.index'))->assertSessionHas('status', 'resource-deleted');

        $this->assertModelMissing($file);
        Storage::disk('local')->assertMissing($file->path);
        Storage::disk('local')->assertExists($other->path);
    }

    public function test_guest_list_sends_login_and_returns_to_list_after_login(): void
    {
        $file = $this->storedFile(['title' => '공개 소개서']);
        $hidden = $this->storedFile(['title' => '숨긴 자료', 'is_published' => false]);
        $member = $this->member();

        $this->get(route('resources.index'))
            ->assertOk()
            ->assertSee('공개 소개서')
            ->assertDontSee('숨긴 자료')
            ->assertSee('로그인하고 받기')
            ->assertSee('href="'.route('login').'"', false)
            ->assertDontSee(route('resources.download', $file), false)
            ->assertDontSee($file->path, false);

        $this->post('/login', ['email' => $member->email, 'password' => 'password'])
            ->assertRedirect(route('resources.index'));

        $this->get(route('resources.index'))
            ->assertOk()
            ->assertSee('href="'.route('resources.download', $file).'"', false)
            ->assertDontSee(route('resources.download', $hidden), false)
            ->assertDontSee($file->path, false);
    }

    public function test_guest_list_returns_to_list_after_registration(): void
    {
        $this->get(route('resources.index'))->assertOk();

        $this->post('/register', [
            'name' => '새 회원',
            'email' => 'new-member@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('resources.index'));
    }

    public function test_list_and_admin_screens_are_noindex_on_public_host(): void
    {
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->storedFile();
        $robots = '<meta name="robots" content="noindex, nofollow">';

        $this->get('https://j-curve.co.kr/resources')->assertOk()->assertSee($robots, false);
        $this->actingAs($this->admin())->get('https://j-curve.co.kr/admin/resources')->assertOk()->assertSee($robots, false);
    }

    public function test_request_over_post_limit_shows_korean_413_page(): void
    {
        if ((int) ini_get('post_max_size') === 0) {
            $this->markTestSkipped('post_max_size 무제한 환경');
        }

        $this->actingAs($this->admin())
            ->call('POST', route('admin.resources.store'), [], [], [], [
                'CONTENT_LENGTH' => (string) (1024 * 1024 * 1024),
                'HTTP_REFERER' => 'https://evil.example/back',
            ])
            ->assertStatus(413)
            ->assertSee('20MB 이하')
            ->assertDontSee('evil.example');
        $this->assertSame(0, ResourceFile::count());
    }

    public function test_resources_stay_out_of_sitemaps_rss_and_llms(): void
    {
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->storedFile(['title' => '피드 제외 자료']);

        foreach (['/sitemap.xml', '/sitemaps/pages/1.xml', '/sitemaps/services/1.xml', '/rss', '/llms.txt'] as $url) {
            $content = (string) $this->get($url)->assertOk()->getContent();

            $this->assertDoesNotMatchRegularExpression('#/(admin/)?resources(/|<|"|\s|$)#', $content, $url);
            $this->assertStringNotContainsString('피드 제외 자료', $content, $url);
        }
    }

    private function member(): User
    {
        return User::factory()->create();
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['role' => 'admin'])->save();

        return $user->fresh();
    }

    private function storedFile(array $attributes = []): ResourceFile
    {
        $path = 'resources/'.Str::random(40).'.pdf';
        Storage::disk('local')->put($path, self::PDF_BYTES);

        return ResourceFile::create(array_merge([
            'title' => '자료 '.Str::random(6),
            'original_name' => '자료.pdf',
            'path' => $path,
            'mime' => 'application/pdf',
            'size' => strlen(self::PDF_BYTES),
            'is_published' => true,
        ], $attributes));
    }

    private function realUpload(string $bytes, string $clientName): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'res');
        file_put_contents($path, $bytes);
        $this->tempFiles[] = $path;

        return new UploadedFile($path, $clientName, 'application/pdf', null, true);
    }
}
