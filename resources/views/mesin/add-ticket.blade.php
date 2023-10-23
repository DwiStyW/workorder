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
            Buat WO
        @endslot
    @endcomponent
    <div>
        <form action="{{ route('post.ticket') }}" method="POST">
            @csrf
            <input type="text" name="text">
            <button type="submit">submit</button>
        </form>
    </div>
@endsection
@section('script')
@endsection
