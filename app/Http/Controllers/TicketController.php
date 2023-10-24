<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Events\TicketSent;
use App\Models\Mesin;
use App\Models\Ruang;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\NotificationRepository;
use App\Repositories\TicketRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct(private NotificationRepository $notif, private TicketRepository $ticket){
        $this->notif=$notif;
        $this->ticket=$ticket;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notif=$this->notif->getNotif((int) $request->user()->id);

        $divisi=$request->user()->divisi;
        $role=$request->user()->role;

        if($role=='user'){
            $tiket_perRole=['user'];
        }else if($role=='kabag' || $role=='admin' || $role=='manager'){
            $tiket_perRole=['kabag','user'];
        }

        if($divisi==Null){
            $tiket=Ticket::leftjoin('mesins','mesins.id','=','tickets.mesin')
                ->leftjoin('ruangs','ruangs.id','=','tickets.ruang')
                ->orderByDesc('id')
                ->select('tickets.*','nama_mesin','nama_ruang')
                ->get();
        }else{
            $tiket=Ticket::leftjoin('users','users.name','=','tickets.pelapor')
                ->leftjoin('mesins','mesins.id','=','tickets.mesin')
                ->leftjoin('ruangs','ruangs.id','=','tickets.ruang')
                ->whereIn('role',$tiket_perRole)
                ->where('tickets.divisi',$divisi)
                ->orderByDesc('id')
                ->select('tickets.*','nama_mesin','nama_ruang')
                ->get();
        }
        // dump($tiket);

        return view('ticket.list-ticket',compact('notif','tiket'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $nomor_tiket=$this->ticket->getNotiket();
        $tanggal=date("Y-m-d");
        // pelapor
        if($request->user()->divisi=='PRO' && $request->user()->role=='user'){
            $getPelapor=User::where('divisi','PRO')
                ->where('role','user')
                ->get();
            foreach($getPelapor as $gP){
                if($gP->name!=$request->user()->name){
                    $pelapor[]=[
                        'nama'=>$gP->name
                    ];
                }
            }
        }else{
            $pelapor[]=[
                'nama'=>$request->user()->name
            ];
        }
        $divisi=$request->user()->divisi;
        $mesin=Mesin::get();
        $ruang=Ruang::get();

        $notif=$this->notif->getNotif((int) $request->user()->id);
        return view('ticket.add-ticket',compact('notif','nomor_tiket','tanggal','pelapor','divisi','mesin','ruang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $data=[
            'name'=>$request->user()->name,
            'divisi'=>$request->user()->divisi,
            'text'=>$request->text
        ];

        $divisi=$request->user()->divisi;
        $role=$request->user()->role;

        if($role=='user'){
            $kirimke=['kabag','admin','manager'];
        }else if($role=='kabag'){
            $kirimke=['admin','manager'];
        }

        $userpenerima=User::where('divisi',$divisi)
            ->whereIn('role',$kirimke)
            ->orwhereNull('divisi')
            ->get();

        DB::beginTransaction();
        try {
            foreach ($userpenerima as $up) {
                $notif=[
                    'sender_id'=>$request->user()->id,
                    'receiver_id'=>$up->id,
                    'type'=>'new',
                    'data'=>json_encode($data),
                ];
                $notification = $this->notif->sendNotif($notif);

                event(new NotificationSent($notification));
            }

            DB::commit();
            $next_nomor_tiket=$this->ticket->getNotiket();
            event(new TicketSent($next_nomor_tiket));
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}