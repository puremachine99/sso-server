<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error Playground</title>
    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            margin: 24px
        }

        a,
        button {
            display: inline-block;
            margin: 6px 8px;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #ddd
        }

        a:hover,
        button:hover {
            background: #f6f8fb
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
            margin-top: 8px
        }
    </style>
</head>

<body>
    <h1>Test Error Pages</h1>
    <p class="muted">Klik salah satu untuk memicu error dan melihat tampilan custom di
        <code>resources/views/errors/</code>.
    </p>

    <div>
        <a href="{{ route('test.error.404') }}" target="_blank">Trigger 404</a>
        <a href="{{ route('test.error.403') }}" target="_blank">Trigger 403</a>
        <a href="{{ route('test.error.401') }}" target="_blank">Trigger 401</a>
        <a href="{{ route('test.error.419') }}" target="_blank">Trigger 419</a>
        <a href="{{ route('test.error.429') }}" target="_blank">Trigger 429</a>
        <a href="{{ route('test.error.500') }}" target="_blank">Trigger 500 (hoki2an, soale sulit simulasi error e )</a>
        <a href="{{ route('test.error.503') }}" target="_blank">Trigger 503</a>
    </div>

    <hr style="margin:18px 0">

    <h2>Trigger 422 (validation)</h2>
    <p class="muted">Submit tanpa field <code>email</code> untuk memicu 422 dengan pesan validasi.</p>
    <form action="{{ route('test.error.422') }}" method="post">
        {{-- jangan kirim @csrf + field email supaya 422 --}}
        {{-- Sengaja TIDAK menambahkan @csrf & input email --}}
        <button type="submit">POST tanpa email (422)</button>
    </form>
</body>

</html>
