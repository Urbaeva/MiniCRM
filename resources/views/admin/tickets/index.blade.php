@extends('layouts.admin')

@section('title', 'Заявки')

@section('content')
    <div class="card">
        <h2 style="margin-bottom:1rem; font-size:1.25rem;">Заявки</h2>

        <form method="GET" action="{{ route('admin.tickets.index') }}">
            <div class="filter-row">
                <div class="form-group">
                    <label for="status">Статус</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Все</option>
                        <option value="new" @selected(request('status') === 'new')>Новый</option>
                        <option value="in_progress" @selected(request('status') === 'in_progress')>В работе</option>
                        <option value="resolved" @selected(request('status') === 'resolved')>Обработан</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_from">Дата от</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <div class="form-group">
                    <label for="date_to">Дата до</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}" placeholder="email@...">
                </div>

                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ request('phone') }}" placeholder="+7...">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Фильтр</button>
                </div>
            </div>
        </form>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Тема</th>
                <th>Клиент</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Статус</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ Str::limit($ticket->subject, 40) }}</td>
                    <td>{{ $ticket->customer->name }}</td>
                    <td>{{ $ticket->customer->email }}</td>
                    <td>{{ $ticket->customer->phone }}</td>
                    <td>
                        @php
                            $labels = ['new' => 'Новый', 'in_progress' => 'В работе', 'resolved' => 'Обработан'];
                        @endphp
                        <span class="badge badge-{{ $ticket->status }}">{{ $labels[$ticket->status] ?? $ticket->status }}</span>
                    </td>
                    <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                    <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">Открыть</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#6b7280;">Заявки не найдены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $tickets->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
