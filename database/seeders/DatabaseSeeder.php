<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\TranslationEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tr = Language::updateOrCreate(
            ['code' => 'tr'],
            ['name' => 'Turkce', 'direction' => 'ltr', 'is_default' => true, 'is_active' => true, 'sort_order' => 1]
        );

        $en = Language::updateOrCreate(
            ['code' => 'en'],
            ['name' => 'English', 'direction' => 'ltr', 'is_default' => false, 'is_active' => true, 'sort_order' => 2]
        );

        $pages = [
            ['home', 'landing', 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1600&q=80', 'Kurumsal projeleri planlayan, sahaya indiren ve olceklendiren muhurendislik ortagi.', 'Kordis, uretim tesisleri, lojistik merkezleri ve enerji altyapilari icin konsept tasarimdan devreye almaya kadar tek sorumlu ekip modeliyle calisir.', 'Demo; kurumsal anlatim, hizmet kartlari, proje vitrinleri ve iletisim akisini gosterecek sekilde hazir HTML olarak teslim edilmistir. Laravel entegrasyonunda icerikler CMS alanlarina baglanabilir.', 'A technical partner that plans, delivers and scales corporate projects in the field.', 'Kordis works with a single accountable team model from concept design to commissioning for production facilities, logistics centers and energy infrastructure.', 'This demo is delivered as ready HTML to show corporate storytelling, service cards, project showcases and the contact flow. During Laravel integration, content can be connected to CMS fields.'],
            ['hakkimizda', 'content', 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80', 'Hakkimizda', 'Kurumsal hikayenizi guven veren bir yapida anlatin', 'Vizyon, misyon, tarihce ve ekip alanlari yonetim panelinden farkli dillerde duzenlenebilir.', 'About Us', 'Tell your corporate story with confidence', 'Vision, mission, history and team content can be managed from the panel in multiple languages.'],
            ['hizmetler', 'listing', 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1600&q=80', 'Hizmetler', 'Hizmetlerinizi moduler ve olceklenebilir anlatin', 'Kurumsal hizmet kartlari, detay sayfalari ve teklif aksiyonlari ayni icerik modeline baglidir.', 'Services', 'Present services through a scalable structure', 'Service cards, detail pages and request actions share the same manageable content model.'],
            ['hizmet-detay', 'detail', 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1600&q=80', 'Hizmet Detay', 'Her hizmet icin ayri SEO ve icerik alani', 'Detay sayfalarinda baslik, aciklama, gorsel, meta baslik ve meta aciklama panelden degistirilebilir.', 'Service Detail', 'Dedicated SEO and content for every service', 'Detail pages include editable title, copy, image, meta title and meta description fields.'],
            ['projeler', 'listing', 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1600&q=80', 'Projeler', 'Referanslarinizi filtrelenebilir bir vitrine tasiyin', 'Proje listeleme kurgusu sektor, yil ve hizmet tipine gore genisletilebilir sekilde hazirlandi.', 'Projects', 'Turn references into a structured showcase', 'The project listing can be extended by sector, year and service type.'],
            ['proje-detay', 'detail', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80', 'Proje Detay', 'Proje hikayesi, kapsam ve sonuclar tek sayfada', 'Demo detay sayfasi gorsel galeri, metrikler ve cagrilar icin uygun alana sahiptir.', 'Project Detail', 'Scope, story and outcomes on one page', 'The demo detail page is ready for galleries, metrics and calls to action.'],
            ['sektorler', 'listing', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80', 'Sektorler', 'Farkli sektorler icin hedefli anlatim', 'Her sektor sayfasi farkli dilde ayri baslik, aciklama ve SEO alanlari ile yonetilebilir.', 'Industries', 'Targeted messaging for each industry', 'Every industry page can have its own titles, descriptions and SEO fields per language.'],
            ['blog', 'listing', 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1600&q=80', 'Blog', 'Icerik pazarlamasi icin hazir yayin akisi', 'Blog listeleme ve detay sablonlari kategori, etiket ve yazar yapisina genisletilebilir.', 'Blog', 'A publishing flow for content marketing', 'Blog listing and detail templates are ready to expand with categories, tags and authors.'],
            ['blog-detay', 'detail', 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?auto=format&fit=crop&w=1600&q=80', 'Blog Detay', 'Okunabilir, SEO uyumlu makale sablonu', 'Makale basliklari, spot metinleri ve govde icerikleri panelde dil sekmeleriyle duzenlenebilir.', 'Blog Detail', 'Readable SEO friendly article template', 'Article titles, summaries and body content are edited with language tabs in the admin panel.'],
            ['kariyer', 'content', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80', 'Kariyer', 'Adaylara net ve profesyonel bir deneyim sunun', 'Acik pozisyonlar ve basvuru kurgusu bu demo uzerinden kolayca genisletilebilir.', 'Careers', 'Offer candidates a clear professional journey', 'Open positions and application flows can be added on top of this demo structure.'],
            ['kalite', 'content', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1600&q=80', 'Kalite', 'Standartlarinizi ve belgelerinizi yonetin', 'Kalite politikalari, sertifikalar ve belge gorselleri panel tarafinda dinamik hale getirilebilir.', 'Quality', 'Manage standards and certificates', 'Quality policies, certificates and document visuals can be made fully dynamic.'],
            ['surdurulebilirlik', 'content', 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=1600&q=80', 'Surdurulebilirlik', 'Etki odakli kurumsal anlatim', 'Sosyal sorumluluk, cevre politikasi ve rapor alanlari coklu dil yapisina uygundur.', 'Sustainability', 'Impact focused corporate storytelling', 'Social responsibility, environmental policy and report areas fit the multilingual structure.'],
            ['galeri', 'media', 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1600&q=80', 'Galeri', 'Gorsel arsivinizi temiz bir yapida sunun', 'Galeri sayfasi kategori ve siralama alanlariyla medya yonetimine genisletilebilir.', 'Gallery', 'Present visual archives in a clean layout', 'The gallery page can be expanded with media categories and ordering.'],
            ['sss', 'content', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1600&q=80', 'Sikca Sorulan Sorular', 'Tekrarlanan sorulari panelden yonetin', 'SSS kurgusu soru-cevap bloklari ve dil bazli icerik girisi icin hazirdir.', 'FAQ', 'Manage recurring questions from the panel', 'The FAQ setup is ready for question-answer blocks and language based entries.'],
            ['iletisim', 'form', 'https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&w=1600&q=80', 'Iletisim', 'Form kaydi ve e-posta bildirimi ayni anda calisir', 'Ziyaretci mesajlari veritabanina kaydedilir, panelden okunur ve mail loguna bildirim duser.', 'Contact', 'Form storage and email notification work together', 'Visitor messages are saved in the database, visible in the panel and sent to the mail log.'],
            ['teklif-al', 'form', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1600&q=80', 'Teklif Al', 'Satis ekibine dogrudan talep akisi', 'Teklif formlari CRM veya e-posta surecine baglanabilecek sekilde ayrica modellenebilir.', 'Request a Quote', 'Direct request flow for the sales team', 'Quote request forms can be modeled separately and connected to CRM or email workflows.'],
        ];

        $menuTitles = [
            'home' => ['tr' => 'Ana Sayfa', 'en' => 'Home'],
            'hakkimizda' => ['tr' => 'Hakkimizda', 'en' => 'About Us'],
            'hizmetler' => ['tr' => 'Hizmetler', 'en' => 'Services'],
            'projeler' => ['tr' => 'Projeler', 'en' => 'Projects'],
            'blog' => ['tr' => 'Blog', 'en' => 'Blog'],
            'iletisim' => ['tr' => 'Iletisim', 'en' => 'Contact'],
        ];

        foreach ($pages as $index => [$slug, $type, $image, $trTitle, $trSubtitle, $trBody, $enTitle, $enSubtitle, $enBody]) {
            $page = Page::updateOrCreate(
                ['slug' => $slug],
                ['type' => $type, 'image_url' => $image, 'is_published' => true, 'sort_order' => $index + 1]
            );

            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $tr->id],
                [
                    'menu_title' => $menuTitles[$slug]['tr'] ?? $trTitle,
                    'title' => $trTitle,
                    'subtitle' => $trSubtitle,
                    'body' => $trBody,
                    'meta_title' => $trTitle.' | Kurumsal Demo',
                    'meta_description' => $trSubtitle,
                ]
            );

            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $en->id],
                [
                    'menu_title' => $menuTitles[$slug]['en'] ?? $enTitle,
                    'title' => $enTitle,
                    'subtitle' => $enSubtitle,
                    'body' => $enBody,
                    'meta_title' => $enTitle.' | Corporate Demo',
                    'meta_description' => $enSubtitle,
                ]
            );
        }

        $translations = [
            'nav.home' => ['tr' => 'Ana Sayfa', 'en' => 'Home'],
            'nav.panel' => ['tr' => 'Yonetim Paneli', 'en' => 'Admin Panel'],
            'nav.language' => ['tr' => 'Dil', 'en' => 'Language'],
            'cta.offer' => ['tr' => 'Teklif Al', 'en' => 'Request Quote'],
            'cta.contact' => ['tr' => 'Iletisime Gec', 'en' => 'Contact Us'],
            'home.metrics.pages' => ['tr' => '16 sayfa tasarimi', 'en' => '16 page templates'],
            'home.metrics.languages' => ['tr' => 'Sinirsiz dil yapisi', 'en' => 'Unlimited languages'],
            'home.metrics.panel' => ['tr' => 'Tam panel kontrolu', 'en' => 'Full panel control'],
            'section.featured' => ['tr' => 'Dinamik alanlar', 'en' => 'Dynamic sections'],
            'section.featured_text' => ['tr' => 'Sayfa basliklari, gorseller, metinler, SEO alanlari ve sabit kelimeler panelden yonetilir.', 'en' => 'Page titles, images, copy, SEO fields and fixed interface words are managed from the panel.'],
            'section.contact_title' => ['tr' => 'Iletisim formu', 'en' => 'Contact form'],
            'section.contact_text' => ['tr' => 'Gonderimler veritabanina kaydedilir ve mail bildirimi Laravel log mailer uzerinden uretilir.', 'en' => 'Submissions are saved in the database and email notifications are generated through Laravel log mailer.'],
            'form.name' => ['tr' => 'Ad Soyad', 'en' => 'Full Name'],
            'form.email' => ['tr' => 'E-posta', 'en' => 'Email'],
            'form.phone' => ['tr' => 'Telefon', 'en' => 'Phone'],
            'form.company' => ['tr' => 'Firma', 'en' => 'Company'],
            'form.subject' => ['tr' => 'Konu', 'en' => 'Subject'],
            'form.message' => ['tr' => 'Mesaj', 'en' => 'Message'],
            'form.submit' => ['tr' => 'Gonder', 'en' => 'Send'],
            'contact.success' => ['tr' => 'Mesajiniz kaydedildi. Demo panelden goruntuleyebilirsiniz.', 'en' => 'Your message has been saved. You can view it in the demo panel.'],
            'footer.copy' => ['tr' => 'Laravel kurumsal CMS demo', 'en' => 'Laravel corporate CMS demo'],
            'client.skip' => ['tr' => 'Icerige gec', 'en' => 'Skip to content'],
            'client.home_aria' => ['tr' => 'Kordis ana sayfa', 'en' => 'Kordis home'],
            'client.menu_toggle' => ['tr' => 'Menuyu ac veya kapat', 'en' => 'Open or close menu'],
            'client.language_label' => ['tr' => 'Dil secimi', 'en' => 'Language selection'],
            'client.hero_eyebrow' => ['tr' => 'Endustriyel tesisler ve akilli altyapi', 'en' => 'Industrial facilities and smart infrastructure'],
            'client.cta.quote' => ['tr' => 'Teklif Iste', 'en' => 'Request a Proposal'],
            'client.cta.projects' => ['tr' => 'Projeleri Incele', 'en' => 'View Projects'],
            'client.metrics_aria' => ['tr' => 'Sirket istatistikleri', 'en' => 'Company statistics'],
            'client.metric.experience' => ['tr' => 'yil saha deneyimi', 'en' => 'years of field experience'],
            'client.metric.facilities' => ['tr' => 'teslim edilen tesis', 'en' => 'facilities delivered'],
            'client.metric.support' => ['tr' => 'operasyon destegi', 'en' => 'operations support'],
            'client.intro_eyebrow' => ['tr' => 'Tek merkezden koordinasyon', 'en' => 'Centralized coordination'],
            'client.intro_title' => ['tr' => 'Yonetim kurullari icin net raporlama, saha ekipleri icin uygulanabilir plan.', 'en' => 'Clear reporting for boards, actionable plans for field teams.'],
            'client.services_eyebrow' => ['tr' => 'Hizmet kapsamimiz', 'en' => 'Service scope'],
            'client.services_title' => ['tr' => 'Planlama, uygulama ve isletme tarafinda tamamlayici disiplinler.', 'en' => 'Complementary disciplines across planning, delivery and operations.'],
            'client.service1.title' => ['tr' => 'Tesis Planlama', 'en' => 'Facility Planning'],
            'client.service1.text' => ['tr' => 'Yatirim hedefleri, izin surecleri, kapasite modellemesi ve fazlama planlari tek teknik dosyada toplanir.', 'en' => 'Investment goals, permit processes, capacity modeling and phasing plans are gathered in one technical file.'],
            'client.service2.title' => ['tr' => 'Proje Yonetimi', 'en' => 'Project Management'],
            'client.service2.text' => ['tr' => 'Satin alma, saha takvimi, alt yuklenici koordinasyonu ve risk raporlamasi haftalik ritimle yonetilir.', 'en' => 'Procurement, field schedule, subcontractor coordination and risk reporting are managed in a weekly rhythm.'],
            'client.service3.title' => ['tr' => 'Enerji Sistemleri', 'en' => 'Energy Systems'],
            'client.service3.text' => ['tr' => 'Trafo, dagitim, izleme ve verimlilik projeleri icin olculen, bakimi yapilabilir sistemler kurulur.', 'en' => 'Measurable and maintainable systems are built for transformer, distribution, monitoring and efficiency projects.'],
            'client.service4.title' => ['tr' => 'Operasyon Destegi', 'en' => 'Operations Support'],
            'client.service4.text' => ['tr' => 'Devreye alma sonrasinda performans izleme, ariza protokolleri ve ekip egitimleriyle sureklilik saglanir.', 'en' => 'After commissioning, continuity is supported with performance monitoring, incident protocols and team training.'],
            'client.detail' => ['tr' => 'Detay al', 'en' => 'View details'],
            'client.projects_eyebrow' => ['tr' => 'Proje vitrinleri', 'en' => 'Project showcases'],
            'client.projects_title' => ['tr' => 'Yuksek temasli sahalarda olculebilir teslimatlar.', 'en' => 'Measurable delivery in high-touch field environments.'],
            'client.projects_link' => ['tr' => 'Yaklasimimizi okuyun', 'en' => 'Read our approach'],
            'client.project1.type' => ['tr' => 'Lojistik merkezi', 'en' => 'Logistics center'],
            'client.project1.title' => ['tr' => 'Gebze Otomasyonlu Depo Kampusu', 'en' => 'Gebze Automated Warehouse Campus'],
            'client.project1.text' => ['tr' => '36.000 m2 kapali alan, yangin senaryolari ve enerji izleme altyapisi 11 ayda teslim edildi.', 'en' => '36,000 m2 of enclosed space, fire scenarios and energy monitoring infrastructure were delivered in 11 months.'],
            'client.project1.fact1.label' => ['tr' => 'Alan', 'en' => 'Area'],
            'client.project1.fact1.value' => ['tr' => '36K m2', 'en' => '36K m2'],
            'client.project1.fact2.label' => ['tr' => 'Sorumluluk', 'en' => 'Responsibility'],
            'client.project1.fact2.value' => ['tr' => 'EPC-M', 'en' => 'EPC-M'],
            'client.project2.type' => ['tr' => 'Enerji modernizasyonu', 'en' => 'Energy modernization'],
            'client.project2.title' => ['tr' => 'Manisa Uretim Hatti Verimlilik Programi', 'en' => 'Manisa Production Line Efficiency Program'],
            'client.project2.text' => ['tr' => 'Hat bazli olcumleme, reaktif guc iyilestirmesi ve bakim planlariyla pik tuketim dusuruldu.', 'en' => 'Peak consumption was reduced through line-based measurement, reactive power improvement and maintenance plans.'],
            'client.project2.fact1.label' => ['tr' => 'Kazanc', 'en' => 'Gain'],
            'client.project2.fact1.value' => ['tr' => '%14', 'en' => '14%'],
            'client.project2.fact2.label' => ['tr' => 'Sure', 'en' => 'Duration'],
            'client.project2.fact2.value' => ['tr' => '5 ay', 'en' => '5 months'],
            'client.project3.type' => ['tr' => 'Kurumsal merkez', 'en' => 'Corporate hub'],
            'client.project3.title' => ['tr' => 'Izmir Hibrit Ofis ve Veri Odasi', 'en' => 'Izmir Hybrid Office and Data Room'],
            'client.project3.text' => ['tr' => 'Calisma alanlari, guvenlik zonlari ve mikro veri odasi icin kesintisiz gecis planlandi.', 'en' => 'A seamless transition was planned for workspaces, security zones and a micro data room.'],
            'client.project3.fact1.label' => ['tr' => 'Kapasite', 'en' => 'Capacity'],
            'client.project3.fact1.value' => ['tr' => '420 kisi', 'en' => '420 people'],
            'client.project3.fact2.label' => ['tr' => 'SLA', 'en' => 'SLA'],
            'client.project3.fact2.value' => ['tr' => '99.8', 'en' => '99.8'],
            'client.contact_eyebrow' => ['tr' => 'Iletisim', 'en' => 'Contact'],
            'client.contact_title' => ['tr' => 'Bir sonraki yatirim toplantisi icin teknik on degerlendirme hazirlayalim.', 'en' => 'Let us prepare a technical pre-assessment for your next investment meeting.'],
            'client.contact_text' => ['tr' => 'Form gonderimi bu statik prototipte tarayici icinde simule edilir. Entegrasyonda alanlar CRM, e-posta veya Laravel form endpointine baglanabilir.', 'en' => 'Form submission is simulated in the browser in this static prototype. During integration, fields can be connected to CRM, email or a Laravel form endpoint.'],
            'client.contact_notes_label' => ['tr' => 'Iletisim notlari', 'en' => 'Contact notes'],
            'client.contact_note1' => ['tr' => '48 saat icinde on gorusme', 'en' => 'Initial meeting within 48 hours'],
            'client.contact_note2' => ['tr' => 'Gizlilik sozlesmesiyle teknik dosya inceleme', 'en' => 'Technical file review under an NDA'],
            'client.contact_note3' => ['tr' => 'Turkce ve Ingilizce teklif seti', 'en' => 'Turkish and English proposal set'],
            'client.select_placeholder' => ['tr' => 'Seciniz', 'en' => 'Select'],
            'client.interest' => ['tr' => 'Ilgi alani', 'en' => 'Area of interest'],
            'client.option.planning' => ['tr' => 'Tesis planlama', 'en' => 'Facility planning'],
            'client.option.project' => ['tr' => 'Proje yonetimi', 'en' => 'Project management'],
            'client.option.energy' => ['tr' => 'Enerji sistemleri', 'en' => 'Energy systems'],
            'client.option.operations' => ['tr' => 'Operasyon destegi', 'en' => 'Operations support'],
            'client.consent' => ['tr' => 'Kisisel verilerimin teklif sureci icin islenmesini kabul ediyorum.', 'en' => 'I consent to the processing of my personal data for the proposal process.'],
            'client.meeting_request' => ['tr' => 'Gorusme Talep Et', 'en' => 'Request a Meeting'],
            'client.footer_address' => ['tr' => 'Maslak, Istanbul / info@kordis.example', 'en' => 'Maslak, Istanbul / info@kordis.example'],
            'client.footer_copy' => ['tr' => 'Kordis. Demo HTML teslim dosyasi.', 'en' => 'Kordis. Demo HTML delivery file.'],
        ];

        foreach ($translations as $key => $values) {
            TranslationEntry::updateOrCreate(
                ['translation_key' => $key, 'language_id' => $tr->id],
                ['group' => 'site', 'value' => $values['tr']]
            );

            TranslationEntry::updateOrCreate(
                ['translation_key' => $key, 'language_id' => $en->id],
                ['group' => 'site', 'value' => $values['en']]
            );
        }

        ContactMessage::firstOrCreate(
            ['email' => 'ayse@example.com', 'subject' => 'Kurumsal site teklifi'],
            [
                'locale' => 'tr',
                'name' => 'Ayse Demir',
                'phone' => '+90 555 000 00 00',
                'company' => 'Demo Holding',
                'message' => 'Coklu dil destekli kurumsal site icin gorusmek istiyoruz.',
                'is_read' => false,
            ]
        );
    }
}
