@extends('layouts.app')

@section('content')
    <div class="uk-container">
        <div class="uk-card" uk-card-default>
            <div class="uk-card-header">
                <h3 class="uk-card-title">Admin Approvals</h3>
            </div>
            <div class="uk-card-body">
                <h4>Seller Requests</h4>
                @if (count($seller_approval) > 0)
                    <table class="uk-table" border="1">
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Details</th>
                            <th>Approve/Decline</th>
                        </tr>
                        @foreach ($seller_approval as $approval)
                            <tr>
                                <form action="/admin/approval" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $approval->id }}">
                                    <td> {{ $approval->id }}</td>
                                    <td> {{ $approval->user->username }}</td>
                                    <td>
                                        Name: {{ $approval->user->seller->name }} <br>
                                        Aadhaar: {{ $approval->user->seller->aadhaar }} <br>
                                        GSTIN: {{ $approval->user->seller->gst_number ?? 'Not Registered' }} <br>
                                        Trade Name: {{ $approval->user->seller->trade_name }}
                                    </td>
                                    <td>
                                        <button id='{{ $approval->id }}a' type="submit" name="input" value="approve"
                                            class="uk-button uk-button-link uk-text-primary">
                                            <i class="ri-check-line"></i> Approve
                                        </button>
                                        <br>
                                        <button id='{{ $approval->id }}d' type="submit" name="input" value="decline"
                                            class="uk-button uk-button-link uk-text-danger">
                                            <i class="ri-close-line"></i> Decline
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>No seller request pending</p>
                @endif


                <h4>Admin Requests</h4>
                @if (count($admin_approval) > 0)
                    <table class="uk-table" border="1">
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Approve/Decline</th>
                        </tr>

                        @foreach ($admin_approval as $approval)
                            <tr>
                                <form action="{{ route('routeadmin.approval') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $approval->id }}">
                                    <td> {{ $approval->id }} </td>
                                    <td> {{ $approval->user->username }}</td>
                                    <td>
                                        <button id='{{ $approval->id }}a' type="submit" name="input" value="approve"
                                            class="uk-button uk-button-link uk-text-primary">
                                            <i class="ri-check-line"></i> Approve
                                        </button>
                                        <br>
                                        <button id='{{ $approval->id }}d' type="submit" name="input" value="decline"
                                            class="uk-button uk-button-link uk-text-danger">
                                            <i class="ri-close-line"></i> Decline
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>No admin request pending</p>
                @endif
            </div>
        </div>
    </div>
@endsection
