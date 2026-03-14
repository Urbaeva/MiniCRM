<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniCRM — @yield('title', 'Панель управления')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; color: #1f2937; line-height: 1.5; }
        .navbar { background: #1e293b; color: #fff; padding: 0.75rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #94a3b8; text-decoration: none; margin-left: 1.5rem; font-size: 0.875rem; }
        .navbar a:hover { color: #fff; }
        .navbar .brand { font-weight: 700; font-size: 1.125rem; color: #fff; }
        .container { max-width: 1200px; margin: 1.5rem auto; padding: 0 1rem; }
        .card { background: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem; margin-bottom: 1.5rem; }
        .alert { padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #6b7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
        tr:hover { background: #f9fafb; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .badge-new { background: #dbeafe; color: #1e40af; }
        .badge-in_progress { background: #fef3c7; color: #92400e; }
        .badge-resolved { background: #d1fae5; color: #065f46; }
        .btn { display: inline-block; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: background 0.15s; }
        .btn-primary { background: #3b82f6; color: #fff; }
        .btn-primary:hover { background: #2563eb; }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.8rem; }
        .btn-link { background: none; color: #3b82f6; padding: 0; }
        .btn-link:hover { text-decoration: underline; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; color: #374151; }
        .form-control { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        select.form-control { appearance: auto; }
        .filter-row { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; margin-bottom: 1rem; }
        .filter-row .form-group { margin-bottom: 0; flex: 1; min-width: 150px; }
        .pagination { display: flex; justify-content: center; gap: 0.25rem; margin-top: 1rem; list-style: none; }
        .pagination li a, .pagination li span { padding: 0.375rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem; text-decoration: none; color: #374151; }
        .pagination li.active span { background: #3b82f6; color: #fff; border-color: #3b82f6; }
        .pagination li.disabled span { color: #9ca3af; }
        .detail-row { display: flex; margin-bottom: 0.75rem; }
        .detail-label { width: 180px; font-weight: 600; color: #6b7280; font-size: 0.875rem; flex-shrink: 0; }
        .detail-value { flex: 1; font-size: 0.875rem; }
        .file-list { list-style: none; }
        .file-list li { padding: 0.375rem 0; }
        .file-list li a { color: #3b82f6; text-decoration: none; }
        .file-list li a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <nav class="navbar">
        <span class="brand">MiniCRM</span>
        <div>
            <a href="{{ route('admin.tickets.index') }}">Заявки</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn-link" style="color:#94a3b8;font-size:0.875rem;margin-left:1.5rem;">Выход</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
