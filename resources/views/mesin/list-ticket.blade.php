@extends('layouts.master-layouts')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Work Order
        @endslot
        @slot('title')
            List WO
        @endslot
    @endcomponent
    <div>
        <a href="{{ route('add.ticket') }}">Buat WO</a>
    </div>
@endsection
@section('script')
@endsection
