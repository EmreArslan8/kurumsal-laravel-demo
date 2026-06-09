<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Language;
use App\Models\Page;
use App\Models\TranslationEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(string $locale = 'tr'): View
    {
        return $this->clientDemo($locale);
    }

    public function page(string $locale, string $slug): View|RedirectResponse
    {
        if ($slug === 'home') {
            return redirect()->route('site.home', ['locale' => $locale]);
        }

        return $this->renderPage($locale, $slug);
    }

    public function clientDemo(string $locale): View
    {
        $language = Language::active()->where('code', $locale)->firstOrFail();
        $languages = Language::active()->orderBy('sort_order')->get();
        $page = Page::query()
            ->with('translations')
            ->where('slug', 'home')
            ->where('is_published', true)
            ->firstOrFail();
        $translation = $page->translationFor($language);

        abort_if(! $translation || ! $translation->title, 404);

        $menuPages = Page::query()
            ->whereIn('slug', ['home', 'hakkimizda', 'hizmetler', 'projeler', 'blog', 'iletisim'])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->with(['translations' => fn ($query) => $query->where('language_id', $language->id)])
            ->get();

        $servicePages = Page::query()
            ->whereIn('slug', ['hizmetler', 'projeler', 'kalite', 'surdurulebilirlik'])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->with(['translations' => fn ($query) => $query->where('language_id', $language->id)])
            ->get();

        return view('site.client-demo', [
            'language' => $language,
            'languages' => $languages,
            'page' => $page,
            'pageTranslation' => $translation,
            'menuPages' => $menuPages,
            'servicePages' => $servicePages,
            'ui' => $this->ui($language),
        ]);
    }

    public function storeContact(Request $request, string $locale): RedirectResponse
    {
        $language = Language::active()->where('code', $locale)->firstOrFail();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:60'],
            'company' => ['nullable', 'string', 'max:160'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $message = ContactMessage::create($data + ['locale' => $language->code]);

        Mail::raw(
            "Yeni iletisim formu\n\nAd: {$message->name}\nE-posta: {$message->email}\nTelefon: {$message->phone}\nKonu: {$message->subject}\n\n{$message->message}",
            fn ($mail) => $mail
                ->to(config('mail.from.address'))
                ->subject('Yeni iletisim formu bildirimi')
        );

        return back()->with('status', $this->ui($language)['contact.success'] ?? 'Mesajiniz alindi.');
    }

    private function renderPage(string $locale, string $slug): View
    {
        $language = Language::active()->where('code', $locale)->firstOrFail();
        $languages = Language::active()->orderBy('sort_order')->get();
        $page = Page::query()
            ->with('translations')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        $translation = $page->translationFor($language);

        abort_if(! $translation || ! $translation->title, 404);

        $menuPages = Page::query()
            ->whereIn('slug', ['home', 'hakkimizda', 'hizmetler', 'projeler', 'blog', 'iletisim'])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->with(['translations' => fn ($query) => $query->where('language_id', $language->id)])
            ->get();

        $featuredPages = Page::query()
            ->whereIn('slug', ['hizmetler', 'projeler', 'kalite', 'surdurulebilirlik', 'kariyer', 'teklif-al'])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->with(['translations' => fn ($query) => $query->where('language_id', $language->id)])
            ->get();

        return view('site.page', [
            'language' => $language,
            'languages' => $languages,
            'page' => $page,
            'pageTranslation' => $translation,
            'menuPages' => $menuPages,
            'featuredPages' => $featuredPages,
            'ui' => $this->ui($language),
        ]);
    }

    private function ui(Language $language): array
    {
        return TranslationEntry::query()
            ->where('language_id', $language->id)
            ->pluck('value', 'translation_key')
            ->all();
    }
}
