@extends('layouts.app')

@section('content')
    <section>
            <h3> Admin List </h3>
            <table class="uk-table" border="1">
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Actions</th>
                </tr>
                @foreach ($admin as $admin)
                    <tr>
                        <form action="/admin/browse" method="POST">
                            @csrf
                            <td> {{ $admin->id }} </td>
                            <td> {{ $admin->name }}</td>
                            <td> {{ $admin->email }}</td>
                            <td>
                                <button id='{{ $admin->id }}a' type="submit" name="input" value="{{ $admin->id }}"
                                    class="uk-button uk-button-link uk-text-primary">
                                    Un-Admin
                                </button>
                            </td>
                        </form>
                    </tr>    
                @endforeach
            </table>
    </section>
@endsection