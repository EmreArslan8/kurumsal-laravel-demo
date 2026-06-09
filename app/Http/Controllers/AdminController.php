<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\TranslationEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($credentials['email'] !== 'admin@demo.test' || $credentials['password'] !== 'demo123') {
            return back()->withErrors(['email' => 'Demo panel bilgileri hatali.'])->onlyInput('email');
        }

        $request->session()->put('demo_admin', true);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('demo_admin');

        return redirect()->route('admin.login');
    }

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'pageCount' => Page::count(),
            'languageCount' => Language::count(),
            'mediaCount' => MediaAsset::count(),
            'messageCount' => ContactMessage::count(),
            'unreadCount' => ContactMessage::where('is_read', false)->count(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }

    public function integration(): View
    {
        $defaultLanguage = $this->defaultLanguage();
        $pages = Page::query()
            ->with(['translations' => fn ($query) => $query->where('language_id', $defaultLanguage?->id)])
            ->orderBy('sort_order')
            ->get();

        return view('admin.integration.show', [
            'sampleHtmlPath' => base_path('client-html-demo/index.html'),
            'sampleCssPath' => base_path('client-html-demo/assets/client-site.css'),
            'sampleJsPath' => base_path('client-html-demo/assets/client-site.js'),
            'pages' => $pages,
        ]);
    }

    public function pages(): View
    {
        $defaultLanguage = $this->defaultLanguage();
        $pages = Page::query()
            ->with(['translations' => fn ($query) => $query->where('language_id', $defaultLanguage?->id)])
            ->orderBy('sort_order')
            ->get();

        return view('admin.pages.index', compact('pages', 'defaultLanguage'));
    }

    public function editPage(Page $page): View
    {
        return view('admin.pages.edit', [
            'page' => $page->load('translations'),
            'languages' => Language::orderBy('sort_order')->get(),
            'mediaAssets' => MediaAsset::latest()->get(),
        ]);
    }

    public function updatePage(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:160', Rule::unique('pages')->ignore($page->id)],
            'type' => ['required', 'string', 'max:80'],
            'image_url' => ['nullable', 'string', 'max:600'],
            'selected_media_url' => ['nullable', 'string', 'max:600'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'translations' => ['array'],
        ]);

        $imageUrl = $data['image_url'] ?? null;

        if ($request->filled('selected_media_url')) {
            $imageUrl = $data['selected_media_url'];
        }

        if ($request->hasFile('hero_image')) {
            $media = $this->storeUploadedMedia($request, 'hero_image');
            $imageUrl = $media->url;
        }

        $page->update([
            'slug' => $data['slug'],
            'type' => $data['type'],
            'image_url' => $imageUrl,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $data['sort_order'],
        ]);

        foreach (Language::all() as $language) {
            $translation = $data['translations'][$language->id] ?? [];

            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $language->id],
                [
                    'menu_title' => $translation['menu_title'] ?? null,
                    'title' => $translation['title'] ?? null,
                    'subtitle' => $translation['subtitle'] ?? null,
                    'body' => $translation['body'] ?? null,
                    'meta_title' => $translation['meta_title'] ?? null,
                    'meta_description' => $translation['meta_description'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.pages.edit', $page)->with('status', 'Sayfa guncellendi.');
    }

    public function media(): View
    {
        return view('admin.media.index', [
            'mediaAssets' => MediaAsset::latest()->paginate(24),
        ]);
    }

    public function storeMedia(Request $request): RedirectResponse
    {
        $this->storeUploadedMedia($request, 'file');

        return back()->with('status', 'Medya yuklendi.');
    }

    public function languages(): View
    {
        return view('admin.languages.index', [
            'languages' => Language::orderBy('sort_order')->get(),
        ]);
    }

    public function storeLanguage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'code' => ['required', 'string', 'max:8', 'alpha_dash', 'unique:languages,code'],
            'direction' => ['required', Rule::in(['ltr', 'rtl'])],
            'is_default' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->boolean('is_default')) {
            Language::query()->update(['is_default' => false]);
        }

        $language = Language::create([
            'name' => $data['name'],
            'code' => strtolower($data['code']),
            'direction' => $data['direction'],
            'is_default' => $request->boolean('is_default'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'],
        ]);

        $sourceLanguage = $this->defaultLanguage(except: $language->id) ?? Language::where('id', '!=', $language->id)->first();

        foreach (Page::all() as $page) {
            $source = $sourceLanguage
                ? PageTranslation::where('page_id', $page->id)->where('language_id', $sourceLanguage->id)->first()
                : null;

            PageTranslation::firstOrCreate(
                ['page_id' => $page->id, 'language_id' => $language->id],
                [
                    'menu_title' => $source?->menu_title,
                    'title' => $source?->title,
                    'subtitle' => $source?->subtitle,
                    'body' => $source?->body,
                    'meta_title' => $source?->meta_title,
                    'meta_description' => $source?->meta_description,
                ]
            );
        }

        TranslationEntry::query()
            ->select('group', 'translation_key')
            ->distinct()
            ->get()
            ->each(fn ($entry) => TranslationEntry::firstOrCreate([
                'group' => $entry->group,
                'translation_key' => $entry->translation_key,
                'language_id' => $language->id,
            ], ['value' => '']));

        return back()->with('status', 'Dil eklendi.');
    }

    public function updateLanguage(Request $request, Language $language): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'code' => ['required', 'string', 'max:8', 'alpha_dash', Rule::unique('languages', 'code')->ignore($language->id)],
            'direction' => ['required', Rule::in(['ltr', 'rtl'])],
            'is_default' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->boolean('is_default')) {
            Language::whereKeyNot($language->id)->update(['is_default' => false]);
        }

        $language->update([
            'name' => $data['name'],
            'code' => strtolower($data['code']),
            'direction' => $data['direction'],
            'is_default' => $request->boolean('is_default'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $data['sort_order'],
        ]);

        return back()->with('status', 'Dil guncellendi.');
    }

    public function translations(): View
    {
        $languages = Language::orderBy('sort_order')->get();
        $entries = TranslationEntry::query()
            ->orderBy('group')
            ->orderBy('translation_key')
            ->get()
            ->groupBy('translation_key');

        return view('admin.translations.index', compact('languages', 'entries'));
    }

    public function updateTranslations(Request $request): RedirectResponse
    {
        foreach ($request->input('entries', []) as $key => $values) {
            foreach ($values as $languageId => $value) {
                TranslationEntry::updateOrCreate(
                    ['translation_key' => $key, 'language_id' => $languageId],
                    ['group' => 'site', 'value' => $value]
                );
            }
        }

        return back()->with('status', 'Ceviriler guncellendi.');
    }

    public function messages(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(12),
        ]);
    }

    public function message(ContactMessage $message): View
    {
        $message->update(['is_read' => true]);

        return view('admin.messages.show', compact('message'));
    }

    private function defaultLanguage(?int $except = null): ?Language
    {
        return Language::query()
            ->when($except, fn ($query) => $query->whereKeyNot($except))
            ->orderByDesc('is_default')
            ->orderBy('sort_order')
            ->first();
    }

    private function storeUploadedMedia(Request $request, string $field): MediaAsset
    {
        $request->validate([
            $field => ['required', 'image', 'max:5120'],
            'alt_text' => ['nullable', 'string', 'max:180'],
        ]);

        $file = $request->file($field);
        $path = $file->store('media', 'public');

        return MediaAsset::create([
            'disk' => 'public',
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize() ?: 0,
            'alt_text' => $request->input('alt_text'),
        ]);
    }
}
