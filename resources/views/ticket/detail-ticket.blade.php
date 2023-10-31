@extends('layouts.master-layouts')
@section('title')
    @lang('Dashboard')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Work Order
        @endslot
        @slot('title')
            Detail WO
        @endslot
    @endcomponent
    <style>
        .timeline {
            border-left: 1px solid hsl(0, 0%, 90%);
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: hsl(0, 0%, 90%);
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }

        .th_title {
            width: 25% !important;
            padding: 5px;
        }

        .pembatas {
            max-width: 10px !important;
        }
    </style>
    @foreach ($tiket as $t)
        <div class="card bg-style mb-3 p-3">
            <table class="w-100">
                <tr>
                    <th class="th_title">Nomor WO</th>
                    <th class="pembatas">:</th>
                    <th>{{ $t->no_tiket }}</th>
                </tr>
                <tr>
                    <th class="th_title">Mesin / Prasarana</th>
                    <th class="pembatas">:</th>
                    <th>{{ $t->no_mesin . ' ' . $t->nama_mesin }}</th>
                </tr>
                <tr>
                    <th class="th_title">Ruang</th>
                    <th class="pembatas">:</th>
                    <th>{{ $t->no_ruang . ' ' . $t->nama_ruang }}</th>
                </tr>
                <tr>
                    <th class="th_title">Status</th>
                    <th class="pembatas">:</th>
                    <th>{{ $t->status }}</th>
                </tr>
            </table>
        </div>
    @endforeach

    <div class="card bg-style">
        <div class="px-5 py-3 mt-4">
            <ul class="timeline">
                @foreach ($riwayat as $r)
                    <li class="timeline-item mb-5">
                        <h5 class="fw-bold">{{ $r->status }}</h5>
                        <p class="text-muted mb-2 fw-bold">{{ date('d F Y H:i:s', strtotime($r->created_at)) }}</p>
                        <p class="text-muted">
                            {{ $r->keterangan }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
