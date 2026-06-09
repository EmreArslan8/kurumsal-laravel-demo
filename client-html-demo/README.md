# Client HTML Demo

This folder is a standalone static prototype intended to represent client-delivered HTML/CSS/JS before Laravel integration. In the real project, the client provides the final 16 HTML page designs; this folder is only a handoff example.

## Files

- `index.html` - Homepage with header, hero, services, project highlights, contact form, and language switcher visuals.
- `about.html` - About page with matching header, hero, story, principles, process, and contact form.
- `assets/client-site.css` - All responsive styling and visual treatments.
- `assets/client-site.js` - Local menu, language switcher visual state, sticky header state, footer year, and demo form validation.

## CMS Markers

The HTML includes comments for integration handoff:

- `CMS:title`
- `CMS:hero_image`
- `CMS:services`
- `CMS:contact_form`

These comments are intentionally visible in source so a Laravel/CMS implementation can replace static copy, image layers, repeatable service records, and form configuration without guessing.

## Usage

Open `index.html` directly in a browser. No build step, package manager, CDN, external font, or third-party script is required.

## Real Project Handoff Flow

The client should provide one HTML file per designed page, plus shared assets:

- `index.html`
- `hakkimizda.html`
- `hizmetler.html`
- `hizmet-detay.html`
- `projeler.html`
- `proje-detay.html`
- `sektorler.html`
- `blog.html`
- `blog-detay.html`
- `kariyer.html`
- `kalite.html`
- `surdurulebilirlik.html`
- `galeri.html`
- `sss.html`
- `iletisim.html`
- `teklif-al.html`

Each file is then mapped to a Laravel page slug, converted to Blade, and connected to CMS fields, translation entries, media records, and form handlers.
