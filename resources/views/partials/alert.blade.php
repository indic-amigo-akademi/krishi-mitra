@php
$alert = Session::get('alert');
@endphp
@if ($alert)
    <script>
        @if ($alert->type == 'Notify')
            Notiflix["{{ $alert->type }}"]["{{ $alert->code }}"]('{{ $alert->subtitle }}')
        @elseif ($alert->type == 'Report')
            Notiflix["{{ $alert->type }}"]["{{ $alert->code }}"]( '{{ $alert->title }}', '{{ $alert->subtitle }}',
            '{{ $alert->confirm }}' );
        @endif
    </script>
@endif
