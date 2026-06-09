# Laravel Kurumsal CMS Demo

Hazir HTML/CSS/JS arayuzlerin Laravel altyapisina baglanmasini gosteren demo projedir. Odak noktalari admin panel, coklu dil, statik ceviri sozlugu, form kaydi, e-posta bildirimi ve medya yonetimidir.

## Demo Kapsami

- 16 sayfalik CMS sayfa modeli
- Hazir HTML teslim akisi ve Blade entegrasyon ornegi
- Turkce/Ingilizce coklu dil yapisi
- Panelde dil sekmeli icerik girisi
- Panelde statik kelime/arayuz ceviri sayfasi
- Iletisim formu kaydi ve mail bildirimi
- Medya kutuphanesi ve sayfa hero gorseline medya atama

## HTML Akisi

Musteriden gelen ham HTML dosyalari referans olarak saklanir:

```txt
client-html-demo/index.html
client-html-demo/about.html
client-html-demo/assets/client-site.css
client-html-demo/assets/client-site.js
```

Laravel'e baglanmis calisan ornek:

```txt
resources/views/site/client-demo.blade.php
resources/views/site/page.blade.php
resources/views/layouts/site.blade.php
```

Canli URL ornekleri:

```txt
/client-html-demo/index.html
/tr/hazir-html-demo
/en/hazir-html-demo
/tr
/en
```

## Admin Panel

```txt
/admin/login
```

Demo giris bilgileri:

```txt
admin@demo.test
demo123
```

Panel bolumleri:

- HTML entegrasyon akisi
- Sayfa yonetimi
- Medya yonetimi
- Dil yonetimi
- Ceviri sozlugu
- Form mesajlari

## Lokal Kurulum

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Test:

```bash
php artisan test
```

## Ucretsiz Demo Deploy Notu

Bu proje Laravel, veritabani, admin session ve medya upload kullandigi icin statik hosting yeterli degildir. Demo icin PHP + MySQL/MariaDB + SSH + Composer destekleyen bir free hosting kullanilmalidir.

AlwaysData benzeri PHP hostinglerde tipik akic:

```bash
cd ~/www
git clone https://github.com/KULLANICI/REPO.git kurumsal-demo
cd kurumsal-demo
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Hosting panelinde site kok dizini Laravel ana klasoru degil, `public` klasoru olmalidir:

```txt
kurumsal-demo/public
```

Production `.env` icin temel ayarlar:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://site-adresi

DB_CONNECTION=mysql
DB_HOST=mysql-host
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```
