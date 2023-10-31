<?php

namespace App\Repositories;

use App\Models\Riwayat;
use App\Models\TanggalLibur;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TicketRepository
{
    public function getNotiket()
    {
        $queryNotiket = Ticket::where('no_tiket', 'not like', "IN%")
            ->orderByDesc('id')
            ->limit(1)
            ->get();
        foreach($queryNotiket as $qNotiket){}
        if(count($queryNotiket)==0){
            $noLm='0000000';
        }else{
            $noLm = $qNotiket->no_tiket;
        }
        // dd($noLm);
        $bln = date('m');
        $thn = date('y');
        $blnTkt = sprintf("%02s", (int) substr($noLm, 3, 2));
        $ThnTkt = sprintf("%02s", (int) substr($noLm, 5, 2));


        if ($blnTkt == $bln && $ThnTkt == $thn) {
            $noU       = (int) substr($noLm, 0, 3);
        } else {
            $noU       = 0;
        }

        $noUrut        = (int) $noU + 1;
        $notik         = sprintf("%03s", $noUrut) . $bln . $thn;

        return $notik;
    }

    public function getDurasi($no_tiket){
        $proses=Riwayat::where('keterangan','like','%Menugaskan kepada%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $selesai=Riwayat::where('keterangan','like','%- WO DONE -%')
            ->where('no_tiket',$no_tiket)
            ->orderby('id','DESC')
            ->limit(1)
            ->select('created_at')
            ->get()
            ->toArray();
        if(count($proses)!=0){
            $tglproses=date('Y-m-d H:i:s',strtotime($proses[0]['created_at']));
        }
        if(count($selesai)!=0){
            $tglselesai=date('Y-m-d H:i:s',strtotime($selesai[0]['created_at']));
        }

        $wktumgrb = strtotime('16:30:00');

        $wktuml = substr($tglproses, 11, 5);
        $wktusls = substr($tglselesai, 11, 5);
        $cekLibur=TanggalLibur::whereBetween('tanggal',[$tglproses,$tglselesai])->get();
        $countLibur=count($cekLibur);

        if (substr($tglproses, 0, 10) != substr($tglselesai, 0, 10)) {
            $jamstar = strtotime($wktumgrb) - strtotime($wktuml);
            $jrkhri  = (strtotime(substr($tglselesai, 0, 10)) - strtotime(substr($tglproses, 0, 10))) / (3600 * 24);
            $jamkrj  = ceil($jrkhri) * 8.5 * 3600;
            $hasil  = ($jamkrj - (strtotime($wktumgrb) - strtotime($wktusls)) + $jamstar) / 3600 - ($countLibur * 8.5);
            $jam     = floor($hasil);
            $menit   = ($hasil - $jam) * 60;
        }else if (substr($tglproses, 0, 10) == substr($tglselesai, 0, 10)) {
            $hasil = strtotime($tglselesai) - strtotime($tglproses);
            $jam = ($hasil / 3600) - ($countLibur * 8.5);
            $menit = ($jam - floor($jam)) * 60;
            $detik = ($menit - floor($menit)) * 60;
        }
        $durasi = ceil($hasil * 60);

        return $durasi;
    }

    public function getHistoryTime($no_tiket){
        $getTiket=Ticket::leftjoin('users','users.name','=','pelapor')
            ->where('no_tiket',$no_tiket)
            // ->select('role')
            ->get()
            ->toArray();

        $baru=Riwayat::where('keterangan','like','%WO baru%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $aprove=Riwayat::where('keterangan','like','%WO APPROVED%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $proses=Riwayat::where('keterangan','like','%Menugaskan kepada%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $beli=Riwayat::where('keterangan','like','%perlu pengajuan%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $sampai=Riwayat::where('keterangan','like','%pembelian berhasil%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $selesai=Riwayat::where('keterangan','like','%- WO DONE -%')
            ->where('no_tiket',$no_tiket)
            ->orderby('id','DESC')
            ->limit(1)
            ->select('created_at')
            ->get()
            ->toArray();

        $close=Riwayat::where('keterangan','like','%- WO CLOSED -%')
            ->where('no_tiket',$no_tiket)
            ->select('created_at')
            ->get()
            ->toArray();

        $tglbaru=date('Y-m-d H:i:s',strtotime($baru[0]['created_at']));
        if(count($aprove)!=0){
            $tglapprove=date('Y-m-d H:i:s',strtotime($aprove[0]['created_at']));
        }
        if(count($proses)!=0){
            $tglproses=date('Y-m-d H:i:s',strtotime($proses[0]['created_at']));
        }
        if(count($selesai)!=0){
            $tglselesai=date('Y-m-d H:i:s',strtotime($selesai[0]['created_at']));
        }
        if(count($close)!=0){
            $tglclose=date('Y-m-d H:i:s',strtotime($close[0]['created_at']));
        }

        $wktumgrb = strtotime('16:30:00');

        // baru to aprove
        if (count($aprove)!=0) {
            $wktuml = substr($tglbaru, 11, 5);
            $wktusls = substr($tglapprove, 11, 5);
            $cekLibur=TanggalLibur::whereBetween('tanggal',[$tglbaru,$tglapprove])->get();
            $countLibur=count($cekLibur);

            if (substr($tglbaru, 0, 10) != substr($tglapprove, 0, 10)) {
                $jamstar = strtotime($wktumgrb) - strtotime($wktuml);
                $jrkhri  = (strtotime(substr($tglapprove, 0, 10)) - strtotime(substr($tglbaru, 0, 10))) / (3600 * 24);
                $jamkrj  = ceil($jrkhri) * 8.5 * 3600;
                $hasil  = ($jamkrj - (strtotime($wktumgrb) - strtotime($wktusls)) + $jamstar) / 3600 - ($countLibur * 8.5);
                $jam     = floor($hasil);
                $menit   = ($hasil - $jam) * 60;
            }else if (substr($tglbaru, 0, 10) == substr($tglapprove, 0, 10)) {
                $hasil = strtotime($tglapprove) - strtotime($tglbaru);
                $jam = ($hasil / 3600) - ($countLibur * 8.5);
                $menit = ($jam - floor($jam)) * 60;
                $detik = ($menit - floor($menit)) * 60;
            }

            if ($hasil > 0 ) {
                if (floor($jam) == 0) {
                    $BaruToAprove=ceil($menit) . ' menit ';
                } else {
                    $BaruToAprove=floor($jam) . ' jam ' . ceil($menit) . ' menit ';
                }
            }else{
                $BaruToAprove='-';
            }
        }
        // aprove to proses
        if (count($aprove)!=0) {
            $wktuml = substr($tglapprove, 11, 5);
            $wktusls = substr($tglproses, 11, 5);
            $cekLibur=TanggalLibur::whereBetween('tanggal',[$tglapprove,$tglproses])->get();
            $countLibur=count($cekLibur);

            if (substr($tglapprove, 0, 10) != substr($tglproses, 0, 10)) {
                $jamstar = strtotime($wktumgrb) - strtotime($wktuml);
                $jrkhri  = (strtotime(substr($tglproses, 0, 10)) - strtotime(substr($tglapprove, 0, 10))) / (3600 * 24);
                $jamkrj  = ceil($jrkhri) * 8.5 * 3600;
                $hasil  = ($jamkrj - (strtotime($wktumgrb) - strtotime($wktusls)) + $jamstar) / 3600 - ($countLibur * 8.5);
                $jam     = floor($hasil);
                $menit   = ($hasil - $jam) * 60;
            }else if (substr($tglapprove, 0, 10) == substr($tglproses, 0, 10)) {
                $hasil = strtotime($tglproses) - strtotime($tglapprove);
                $jam = ($hasil / 3600) - ($countLibur * 8.5);
                $menit = ($jam - floor($jam)) * 60;
                $detik = ($menit - floor($menit)) * 60;
            }

            if ($hasil > 0 ) {
                if (floor($jam) == 0) {
                    $AproveToProses=ceil($menit) . ' menit ';
                } else {
                    $AproveToProses=floor($jam) . ' jam ' . ceil($menit) . ' menit ';
                }
            }else{
                $AproveToProses='-';
            }

        }else{
            $wktuml = substr($tglbaru, 11, 5);
            $wktusls = substr($tglproses, 11, 5);
            $cekLibur=TanggalLibur::whereBetween('tanggal',[$tglbaru,$tglproses])->get();
            $countLibur=count($cekLibur);

            if (substr($tglbaru, 0, 10) != substr($tglproses, 0, 10)) {
                $jamstar = strtotime($wktumgrb) - strtotime($wktuml);
                $jrkhri  = (strtotime(substr($tglproses, 0, 10)) - strtotime(substr($tglbaru, 0, 10))) / (3600 * 24);
                $jamkrj  = ceil($jrkhri) * 8.5 * 3600;
                $hasil  = ($jamkrj - (strtotime($wktumgrb) - strtotime($wktusls)) + $jamstar) / 3600 - ($countLibur * 8.5);
                $jam     = floor($hasil);
                $menit   = ($hasil - $jam) * 60;
            }else if (substr($tglbaru, 0, 10) == substr($tglproses, 0, 10)) {
                $hasil = strtotime($tglproses) - strtotime($tglbaru);
                $jam = ($hasil / 3600) - ($countLibur * 8.5);
                $menit = ($jam - floor($jam)) * 60;
                $detik = ($menit - floor($menit)) * 60;
            }
            // dd($tglbaru,$tglproses);
            if ($hasil > 0 ) {
                if (floor($jam) == 0) {
                    $BaruToProses=ceil($menit) . ' menit ';
                } else {
                    $BaruToProses=floor($jam) . ' jam ' . ceil($menit) . ' menit ';
                }
            }else{
                $BaruToProses='-';
            }
        }

        if(count($selesai)!=0 ){
            $durasi=$getTiket[0]['durasi'];
            if ($durasi > 0 ) {
                if ($durasi>60) {
                    $ProsesToSelesai=floor($durasi / 60) . ' jam ' . $durasi % 60 . ' menit';
                } else {
                    $ProsesToSelesai=$durasi . ' menit';
                }
            }else{
                $ProsesToSelesai='-';
            }
        }

        if(count($beli)!=0){
            foreach($beli as $b){

            }
        }

        if($getTiket[0]['role']=='user'){
            $data=[
                "BaruToAprove"=>$BaruToAprove,
                "AproveToProses"=>$AproveToProses,
                "ProsesToSelesai"=>$ProsesToSelesai,
            ];
        }else{
            $data=[
                "BaruToProses"=>$BaruToProses,
                "ProsesToSelesai"=>$ProsesToSelesai,
            ];
        }
        return $data;
    }
}