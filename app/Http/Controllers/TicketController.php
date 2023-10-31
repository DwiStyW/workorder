<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Events\TicketSent;
use App\Models\Mesin;
use App\Models\Notification;
use App\Models\Riwayat;
use App\Models\Ruang;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\NotificationRepository;
use App\Repositories\TicketRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $notif=$this->notif->getNotif((int) $request->user()->id);
        // dd(count($notif));
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

        return view('ticket.add-ticket',compact('notif','nomor_tiket','tanggal','pelapor','divisi','mesin','ruang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('test');
        $request->validate([
            'mesin' => 'required|string',
            'ruang' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        if($_FILES["photo"]["name"] !=''){
            $allowed_ext = array("jpg", "png");
            $ext = explode('.', $_FILES["photo"]["name"]);
            $file_extension = end($ext);
            if(in_array($file_extension, $allowed_ext)){
                $resorce       = $request->file('photo');
                $photo = $request->no_tiket. '.' . $file_extension;
                $resorce->move(\base_path() ."/public/assets/upload/karyawan", $photo);
                echo "Gambar berhasil di upload";
            }else{
                $photo="";
                echo "Gagal upload gambar";
            }
        }else{
            $photo="";
            echo "Gagal upload gambar";
        }


        $dataMesin=Mesin::where('id',$request->mesin)->get();foreach($dataMesin as $dM){}
        $dataRuang=Ruang::where('id',$request->ruang)->get();foreach($dataRuang as $dR){}

        $datatiket=[
            'no_tiket'=>$this->ticket->getNotiket(),
            'tanggal'=>date("Y-m-d H:i:s"),
            'pelapor'=>$request->pelapor,
            'divisi'=>$request->divisi,
            'mesin'=>$request->mesin,
            'ruang'=>$request->ruang,
            'keterangan'=>$request->keterangan,
            'photo'=>$photo,
            'status'=>'new',
            'update_by'=>$request->pelapor,
        ];

        $datariwayat=[
            'no_tiket'=>$this->ticket->getNotiket(),
            'keterangan'=>"WO baru dari " . $request->pelapor . ", Divisi : " . $request->divisi . ", Mesin/Prasarana : " . $dM->no_mesin . ", Ruang : " . $dR->no_ruang . ", Keterangan : " . $request->keterangan,
            'photo'=>$photo,
            'update_by'=>$request->pelapor,
        ];

        $data=[
            'no_tiket'=>$this->ticket->getNotiket(),
            'name'=>$request->pelapor,
            'divisi'=>$request->divisi,
            'mesin'=>$request->mesin,
            'ruang'=>$request->ruang,
            'text'=>"WO baru dari " . $request->pelapor . ", Divisi : " . $request->divisi . ", Mesin/Prasarana : " . $dM->no_mesin . ", Ruang : " . $dR->no_ruang . ", Keterangan : " . $request->keterangan
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
            Ticket::create($datatiket);
            Riwayat::create($datariwayat);
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

            return redirect('ticket');
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

    public function detail_fromnotif($id_notif,$no_tiket){

        Notification::where('id',$id_notif)->update(['read_at'=>date("Y-m-d H:i:s")]);

        $tiket=Ticket::where('no_tiket',$no_tiket)
            ->leftjoin('mesins','mesins.id','=','tickets.mesin')
            ->leftjoin('ruangs','ruangs.id','=','tickets.ruang')
            ->select('tickets.*','nama_mesin','nama_ruang')
            ->get();
        $riwayat=Riwayat::where('no_tiket',$no_tiket)->orderby('created_at','DESC')->get();
        $notif=$this->notif->getNotif((int) Auth::user()->id);

        return view('ticket.detail-ticket',compact('notif','tiket','riwayat'));
    }

    public function detail_fromticket($no_tiket){
        $notif=$this->notif->getNotif((int) Auth::user()->id);
        $HistoryTime=$this->ticket->getHistoryTime($no_tiket);
        dd($HistoryTime);
        $tiket=Ticket::where('no_tiket',$no_tiket)
            ->leftjoin('mesins','mesins.id','=','tickets.mesin')
            ->leftjoin('ruangs','ruangs.id','=','tickets.ruang')
            ->select('tickets.*','nama_mesin','nama_ruang')
            ->get();
        $riwayat=Riwayat::where('no_tiket',$no_tiket)->orderby('created_at','DESC')->get();

        return view('ticket.detail-ticket',compact('notif','tiket','riwayat'));
    }
}