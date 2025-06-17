@extends('layouts.app')

@section('content')
    <h1>Growth Metrics</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>New Members (Last Month)</td>
                <td>{{ $newMembers }}</td>
            </tr>
            <tr>
                <td>Returning Members</td>
                <td>{{ $returningMembers }}</td>
            </tr>
            <tr>
                <td>Total Members</td>
                <td>{{ $totalMembers }}</td>
            </tr>
        </tbody>
    </table>
@endsection
