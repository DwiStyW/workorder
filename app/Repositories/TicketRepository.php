<?php

namespace App\Repositories;

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

}