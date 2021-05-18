@extends('layouts.app')

@section('content')
    <form action="/admin/approval" method="POST">
        @csrf
        <h1>List of Seller Request</h1>
        @if (count($approval_arr) > 0)
            <table border="1">
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>GST Number</td>
                    <td>Trade Name</td>
                    <td>Approve/Decline</td>
                </tr>
                @foreach ($approval_arr as $seller)
                    <tr>
                        <input type="hidden" name="id" value="{{ $seller->id }}">
                        <td> {{ $seller->id }}</td>
                        <td> {{ $seller->name }}</td>
                        <td> {{ $seller->gst_number }}</td>
                        <td> {{ $seller->trade_name }}</td>
                        <td> <button id='{{ $seller->id }}a' type="submit" name="input" value='approve'>Approve</button>
                            /
                            <button id='{{ $seller->id }}d' type="submit" name="input" value="decline">Decline</button>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            NO REQUEST FOUND
        @endif
    </form>
@endsection
