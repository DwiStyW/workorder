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
    <div class="card bg-style p-3">
        <form action="{{ route('post.ticket') }}" method="POST">
            @csrf
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Nomor WO</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ $nomor_tiket }}" name="no_tiket" id="no_tiket"
                        readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Tanggal WO</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ $tanggal }}" name="tanggal" id="tanggal"
                        readonly>
                </div>
            </div>
            @if (count($pelapor) == 1)
                @foreach ($pelapor as $p)
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Nama Pelapor</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $p['nama'] }}" name="pelapor"
                                id="pelapor" readonly>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label">Nama Pelapor</label>
                    <div class="col-md-10">
                        <select class="form-control selectize" type="text" name="pelapor" id="pelapor">
                            <option value="">Pilih Pelapor</option>
                            @foreach ($pelapor as $p)
                                <option value="{{ $p['nama'] }}">{{ $p['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Divisi</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ $divisi }}" name="divisi" id="divisi"
                        readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Mesin/Sarana</label>
                <div class="col-md-10">
                    <select class="form-control selectize" name="mesin" id="mesin">
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesin as $m)
                            <option value="{{ $m->id }}">{{ $m->no_mesin . ' ' . $m->nama_mesin }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Ruang</label>
                <div class="col-md-10">
                    <select class="form-control selectize" name="mesin" id="mesin">
                        <option value="">Pilih Ruang</option>
                        @foreach ($ruang as $r)
                            <option value="{{ $r->id }}">{{ $r->no_ruang . ' ' . $r->nama_ruang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Keterangan</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="5" placeholder="keterangan"></textarea>
                </div>
            </div>
            <input type="text" name="text" id="">
            <button type="submit">submit</button>
        </form>
    </div>
@endsection
@section('script')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" />
    <script src="{{ URL::asset('/assets/js/selectize.min.js') }}"></script>
    <script>
        console.log('test');
        $(document).ready(function() {
            $('.selectize').selectize();
        });
    </script>
    <script>
        Echo.channel(`ticket`)
            .listen('TicketSent', (e) => {
                document.getElementById('no_tiket').value = e.ticket;
                // console.log(e);
            });
    </script>
@endsection
