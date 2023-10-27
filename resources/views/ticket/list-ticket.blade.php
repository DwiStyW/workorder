@extends('layouts.master-layouts-datatable')
@section('title')
    @lang('Dashboard')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
    <style>
        @media(max-width:991.98px) {
            .fs {
                font-size: 12px;
            }
        }
    </style>
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <img src="{{ URL::asset('/assets/images/logo/logokotak.png') }}" alt="" height="70">
            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'user' || Auth::user()->role == 'kabag')
        <div class="mb-3">
            <a href="{{ route('add.ticket') }}" class="btn btn-primary"><i class="uil uil-file-plus-alt"></i> Buat WO</a>
        </div>
    @endif


    <div class="row pb-3">
        <div class="col-sm-2 col-3">
            <div class="card bg-style h-100 pt-1">
                <ul class="list-unstyled">
                    <li class="menu-title">Filter</li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 active fs" href="{{ url('ticket') }}">Semua</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/baru') }}">Baru</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/disetujui') }}">Di Setujui</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/proses') }}">Proses</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/selesai') }}">Selesai</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/ditutup') }}">Di Tutup</a>
                    </li>
                    <li class="m-2 w-80">
                        <a class="btn btn-outline-primary w-100 fs" href="{{ url('ticket/ditolak') }}">Di Tolak</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-10 col-9">
            <div class="card bg-style h-100 p-2">
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap "
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Wo</th>
                            <th>Pelapor</th>
                            <th>Divisi</th>
                            <th>Mesin/Sarana</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                            <th>Di update oleh</th>
                            <th>Tanggal</th>
                            <th>Kepala</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($tiket as $t)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $t->no_tiket }}</td>
                                <td>{{ $t->pelapor }}</td>
                                <td>{{ $t->divisi }}</td>
                                <td>{{ $t->nama_mesin }}</td>
                                <td>{{ $t->nama_ruang }}</td>
                                <td>{{ $t->status }}</td>
                                <td>{{ $t->update_by }}</td>
                                <td>{{ $t->tanggal }}</td>
                                <td>{{ $t->kepala }}</td>
                                <td>{{ $t->prioritas }}</td>
                                <td><i class="uil uil-pencil"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script-datatable')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script>
        sessionStorage.setItem("notif", "hide");

        function lonceng_notif(el) {
            if (sessionStorage.getItem("notif") == "hide") {
                document.getElementById('notifications-dropdown-show').style.display = 'block';
                sessionStorage.setItem("notif", "show");
            } else {
                document.getElementById('notifications-dropdown-show').style.display = 'none';
                sessionStorage.setItem("notif", "hide");
            }
        }

        sessionStorage.setItem("avatar", "hide");

        function avatar(el) {
            if (sessionStorage.getItem("avatar") == "hide") {
                document.getElementById('avatar-dropdown-show').style.display = 'block';
                sessionStorage.setItem("avatar", "show");
            } else {
                document.getElementById('avatar-dropdown-show').style.display = 'none';
                sessionStorage.setItem("avatar", "hide");
            }

        }

        sessionStorage.setItem("menu", "hide");

        function menubars(el) {
            if (sessionStorage.getItem("menu") == "hide") {
                document.getElementById('topnav-menu-content').style.display = 'block';
                sessionStorage.setItem("menu", "show");
            } else {
                document.getElementById('topnav-menu-content').style.display = 'none';
                sessionStorage.setItem("menu", "hide");
            }

        }
        window.onclick = function(el) {
            if (el.target.id === 'notifications-dropdown') {
                lonceng_notif();
            } else if (el.target.id === 'avatar-dropdown') {
                avatar();
            } else if (el.target.id === 'topnav-menu-content') {
                menubars();
            }
        }
    </script>
@endsection
