@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Quote for {{ $device->name }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Issue</th>
                <th>Cost (ZMW)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($selectedIssues as $issue)
                <tr>
                    <td>{{ $issue->issue }}</td>
                    <td>{{ number_format($costs[$issue->id], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>ZMW {{ number_format($totalCost, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('service-requests.store') }}" class="btn btn-primary">Confirm Request</a>
    <a href="{{ route('service-requests.download-quote') }}" class="btn btn-secondary">Download Quote (PDF)</a>
</div>
@endsection
