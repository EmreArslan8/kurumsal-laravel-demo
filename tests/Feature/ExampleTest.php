<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertRedirect('/tr');

        $this->get('/tr')
            ->assertOk()
            ->assertSee('Engineering Group')
            ->assertSee('Endustriyel tesisler ve akilli altyapi')
            ->assertSee('Gebze Otomasyonlu Depo Kampusu');

        $this->get('/en')
            ->assertOk()
            ->assertSee('Industrial facilities and smart infrastructure')
            ->assertSee('A technical partner that plans')
            ->assertSee('Gebze Automated Warehouse Campus')
            ->assertDontSee('Endustriyel tesisler ve akilli altyapi')
            ->assertDontSee('Ad Soyad');

        $this->get('/tr/hazir-html-demo')
            ->assertOk()
            ->assertSee('Engineering Group')
            ->assertSee('Endustriyel tesisler ve akilli altyapi')
            ->assertSee('Kurumsal projeleri planlayan')
            ->assertSee('Gebze Otomasyonlu Depo Kampusu');

        $this->get('/en/hazir-html-demo')
            ->assertOk()
            ->assertSee('Industrial facilities and smart infrastructure')
            ->assertSee('A technical partner that plans')
            ->assertSee('View details')
            ->assertSee('Full Name')
            ->assertSee('Gebze Automated Warehouse Campus')
            ->assertDontSee('Detay al')
            ->assertDontSee('Icerige gec');
    }

    public function test_demo_admin_can_login(): void
    {
        $this->post('/admin/login', [
            'email' => 'admin@demo.test',
            'password' => 'demo123',
        ])
            ->assertRedirect('/admin')
            ->assertSessionHas('demo_admin', true);

        $this->withSession(['demo_admin' => true])
            ->get('/admin/sayfalar')
            ->assertOk()
            ->assertSee('Sayfa Yonetimi');

        $this->withSession(['demo_admin' => true])
            ->get('/admin/html-entegrasyon')
            ->assertOk()
            ->assertSee('16 HTML Teslim Matrisi')
            ->assertSee('client-html-demo/index.html');
    }

    public function test_contact_form_is_saved(): void
    {
        Mail::fake();

        $this->post('/tr/iletisim', [
            'name' => 'Demo Musteri',
            'email' => 'demo@example.com',
            'phone' => '+90 555 111 22 33',
            'company' => 'Demo A.S.',
            'subject' => 'Teklif talebi',
            'message' => 'Laravel kurumsal demo icin gorusmek istiyoruz.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'demo@example.com',
            'subject' => 'Teklif talebi',
        ]);
    }

    public function test_admin_can_upload_media_and_assign_it_to_a_page(): void
    {
        Storage::fake('public');

        $this->withSession(['demo_admin' => true])
            ->from('/admin/medya')
            ->post('/admin/medya', [
                'file' => UploadedFile::fake()->image('hero.jpg', 1200, 800),
                'alt_text' => 'Demo hero gorseli',
            ])
            ->assertRedirect('/admin/medya');

        $this->assertDatabaseHas('media_assets', [
            'original_name' => 'hero.jpg',
            'alt_text' => 'Demo hero gorseli',
        ]);

        $media = \App\Models\MediaAsset::firstOrFail();
        Storage::disk('public')->assertExists($media->path);

        $page = \App\Models\Page::where('slug', 'home')->firstOrFail();

        $this->withSession(['demo_admin' => true])
            ->put("/admin/sayfalar/{$page->id}", [
                'slug' => $page->slug,
                'type' => $page->type,
                'sort_order' => $page->sort_order,
                'is_published' => '1',
                'image_url' => '',
                'selected_media_url' => $media->url,
                'translations' => $page->translations()
                    ->get()
                    ->mapWithKeys(fn ($translation) => [
                        $translation->language_id => [
                            'menu_title' => $translation->menu_title,
                            'title' => $translation->title,
                            'subtitle' => $translation->subtitle,
                            'body' => $translation->body,
                            'meta_title' => $translation->meta_title,
                            'meta_description' => $translation->meta_description,
                        ],
                    ])
                    ->all(),
            ])
            ->assertRedirect("/admin/sayfalar/{$page->id}/duzenle");

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'image_url' => $media->url,
        ]);
    }
}
