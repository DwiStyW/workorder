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
    <style>
        .bg {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.102);
            backdrop-filter: blur(15px);
        }

        .blog-modal-section {
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
        }
    </style>
    <div id="resume" class="bg" style="display:none">
        <div class="modal blog-modal-section">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah ingin melanjutkan inputan sebelumnya?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="reset()" class="btn btn-danger">Reset</button>
                        <button type="button" onclick="lanjutkan()" class="btn btn-primary">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-style p-lg-5 p-md-4 p-2 ">
        <form action="{{ route('post.ticket') }}" method="POST" enctype="multipart/form-data">
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
                        <select class="form-control selectize" placeholder="Pilih Pelapor" type="text" name="pelapor"
                            id="pelapor">
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
                    <select class="form-control selectize" placeholder="Pilih Mesin" name="mesin" id="mesin">
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
                    <select class="form-control selectize" placeholder="Pilih Ruang" name="ruang" id="ruang">
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
            <div class="mb-3 row">
                <label for="example-text-input" class="col-md-2 col-form-label">Foto Kerusakan</label>
                <div class="col-md-10">
                    <input type="file" name="photo" id="photo">
                </div>
            </div>
            <div class="float-end">
                <button type="submit" class="btn btn-success btn-sm">submit</button>
                <input type='reset' value='Reset' id="reset" class="btn btn-danger btn-sm" />
            </div>
        </form>
    </div>
    </div>
@endsection
@section('script-selectize')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" />
    <script src="{{ URL::asset('/assets/js/selectize.min.js') }}"></script>
    <script>
        var $pelapor = @json($pelapor);
        document.getElementById("pelapor").onchange = function() {
            myFunction()
        };
        document.getElementById("mesin").onchange = function() {
            myFunction()
        };
        document.getElementById("ruang").onchange = function() {
            myFunction()
        };
        document.getElementById("keterangan").onchange = function() {
            myFunction()
        };
        document.getElementById("photo").onchange = function() {
            myFunction()
        };
        document.getElementById("reset").onclick = function() {
            reset()
        };

        function myFunction() {
            var pelapor = document.getElementById("pelapor").value;
            var mesin = document.getElementById("mesin").value;
            var ruang = document.getElementById("ruang").value;
            var keterangan = document.getElementById("keterangan").value;
            var photo = document.getElementById("photo").value;
            localStorage.setItem("pelapor", pelapor);
            localStorage.setItem("mesin", mesin);
            localStorage.setItem("ruang", ruang);
            localStorage.setItem("keterangan", keterangan);
            // localStorage.setItem("photo", photo);
        }

        if (localStorage.pelapor == undefined) {
            document.getElementById('resume').style.display = 'none'
        } else {
            document.getElementById('resume').style.display = 'block'
        }

        if ($pelapor.length != 1) {
            document.getElementById("pelapor").value = localStorage.getItem("pelapor");
        }
        document.getElementById("mesin").value = localStorage.getItem("mesin");
        document.getElementById("ruang").value = localStorage.getItem("ruang");
        document.getElementById("keterangan").value = localStorage.getItem("keterangan");

        function lanjutkan() {
            document.getElementById('resume').style.display = 'none';
        }

        function reset(e) {
            // console.log(e);
            localStorage.removeItem("pelapor");
            localStorage.removeItem("mesin");
            localStorage.removeItem("ruang");
            localStorage.removeItem("keterangan");
            // localStorage.removeItem("photo");
            location.reload();
        }

        $(document).ready(function() {
            $('.selectize').selectize();
        });
    </script>
@endsection
