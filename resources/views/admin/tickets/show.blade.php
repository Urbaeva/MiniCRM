@extends('layouts.admin')

@section('title', 'Заявка #' . $ticket->id)

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2 style="font-size:1.25rem;">Заявка #{{ $ticket->id }}</h2>
            <a href="{{ route('admin.tickets.index') }}" class="btn-link">&larr; Назад к списку</a>
        </div>

        <div class="detail-row">
            <div class="detail-label">Тема:</div>
            <div class="detail-value">{{ $ticket->subject }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Клиент:</div>
            <div class="detail-value">{{ $ticket->customer->name }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Email:</div>
            <div class="detail-value">{{ $ticket->customer->email ?? '—' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Телефон:</div>
            <div class="detail-value">{{ $ticket->customer->phone ?? '—' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Статус:</div>
            <div class="detail-value">
                @php
                    $labels = ['new' => 'Новый', 'in_progress' => 'В работе', 'resolved' => 'Обработан'];
                @endphp
                <span class="badge badge-{{ $ticket->status }}">{{ $labels[$ticket->status] ?? $ticket->status }}</span>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Дата создания:</div>
            <div class="detail-value">{{ $ticket->created_at->format('d.m.Y H:i:s') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Ответ менеджера:</div>
            <div class="detail-value">{{ $ticket->manager_responded_at?->format('d.m.Y H:i:s') ?? '—' }}</div>
        </div>

        <div class="detail-row" style="align-items:flex-start;">
            <div class="detail-label">Текст заявки:</div>
            <div class="detail-value" style="white-space:pre-wrap;">{{ $ticket->body }}</div>
        </div>

        @php $files = $ticket->getMedia('attachments'); @endphp
        @if($files->count())
            <div class="detail-row" style="align-items:flex-start;">
                <div class="detail-label">Файлы:</div>
                <div class="detail-value">
                    <ul class="file-list">
                        @foreach($files as $file)
                            <li>
                                <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->file_name }}</a>
                                <span style="color:#6b7280;font-size:0.75rem;">({{ number_format($file->size / 1024, 1) }} КБ)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <h3 style="font-size:1rem; margin-bottom:1rem;">Изменить статус</h3>

        <form method="POST" action="{{ route('admin.tickets.update-status', $ticket->id) }}" style="display:flex; gap:0.75rem; align-items:flex-end;">
            @csrf
            @method('PATCH')

            <div class="form-group" style="margin-bottom:0; flex:1; max-width:250px;">
                <select name="status" class="form-control">
                    <option value="new" @selected($ticket->status === 'new')>Новый</option>
                    <option value="in_progress" @selected($ticket->status === 'in_progress')>В работе</option>
                    <option value="resolved" @selected($ticket->status === 'resolved')>Обработан</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
