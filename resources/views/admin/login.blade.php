<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Panel Giris</title>
    <link rel="stylesheet" href="{{ asset('assets/demo.css') }}">
</head>
<body class="login-shell">
    <form class="login-panel" method="post" action="{{ route('admin.authenticate') }}">
        @csrf
        <span class="brand-symbol large"></span>
        <p class="eyebrow">Laravel CMS</p>
        <h1>Demo Panel Girisi</h1>
        <p class="login-hint">admin@demo.test / demo123</p>

        @if($errors->any())
            <div class="form-error">{{ $errors->first() }}</div>
        @endif

        <label>
            <span>E-posta</span>
            <input type="email" name="email" value="{{ old('email', 'admin@demo.test') }}" required>
        </label>
        <label>
            <span>Sifre</span>
            <input type="password" name="password" value="demo123" required>
        </label>
        <button class="button primary" type="submit">Panele Gir</button>
        <a class="login-link" href="{{ route('site.home', ['locale' => 'tr']) }}">Site on yuzune don</a>
    </form>
</body>
</html>
