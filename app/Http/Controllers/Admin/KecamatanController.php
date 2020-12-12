<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kecamatan;
use App\Provinsi;
use App\Kabupaten;
use App\DetailUsers;
use App\User;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kec = Kecamatan::join('kabupatens', 'kabupatens.id_kab', '=', 'kecamatans.id_kab')
            ->selectRaw('kecamatans.id, kecamatans.id_kec , kecamatans.name as kec , kecamatans.status, kabupatens.name as kab')
            ->paginate(20);
            // ->get();

        return view('admin.kec.index', ['kec' => $kec]);
    }

    public function findKec(Request $request)
    {
        $kec = Kecamatan::join('kabupatens', 'kabupatens.id_kab', '=', 'kecamatans.id_kab')
            ->selectRaw('kecamatans.id, kecamatans.id_kec , kecamatans.name as kec , kecamatans.status, kabupatens.name as kab')
            ->where('kecamatans.name', 'like', "%".$request->find."%")
            ->paginate();

        return view('admin.kec.index', ['kec' => $kec]);
    }

    public function reportMember($id)
    {
        $title = Kecamatan::find($id);

        $report = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
                ->join('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
                ->join('kabupatens', 'detail_users.kabupaten', '=', 'kabupatens.id_kab')
                ->join('kelurahans', 'detail_users.kelurahan', '=', 'kelurahans.id_kel')
                ->selectRaw('detail_users.userid ,provinsis.zona_waktu as provid ,
                        kecamatans.id as kecid ,detail_users.no_member ,
                        users.name ,detail_users.nik ,detail_users.no_hp ,
                        users.email ,users.created_at ,
                        users.is_active ,detail_users.status_korlap, provinsis.name as provname,
                        kabupatens.name as kabname, kecamatans.name as kecname,kelurahans.name as kelname')
                ->where('role_user.role_id', 3);
        if(isset($id)) {
            $report->where('kecamatans.id', $id);
        }
        $report = $report->get();

        return view('admin.kec.report', compact('report', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kab = Kabupaten::all()->pluck('name', 'id_kab');

        return view('admin.kec.create', compact('kab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = Kecamatan::create([
                'id_kab' => $request->id_kab,
                'id_kec' => $request->id_kec,
                'name' => $request->nama,
                'created_by' => \Auth::user()->id,
            ]);
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        return \redirect()->route('admin.kecamatan.index')->with('success',\trans('notif.notification.save_data.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kec = Kecamatan::find($id);
        $kab = Kabupaten::all()->pluck('name', 'id_kab');

        return view('admin.kec.edit', compact('kec', 'kab'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            // dd($request);
            $data = Kecamatan::find($id);
            $data->id_kab = $request->id_kab;
            $data->id_kec = $request->id_kec;
            $data->name = $request->nama;
            $data->updated_by = \Auth::user()->id;
            $data->update();

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        return \redirect()->route('admin.kecamatan.index')->with('success',\trans('notif.notification.save_data.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kecamatan::find($id);
        $data->status  = Kecamatan::NotActive;
        $data->updated_by = \Auth::user()->id;
        $data->deleted_at = \Carbon\Carbon::now();
        $data->update();

        return \redirect()->route('admin.kecamatan.index')->with('success',\trans('notif.notification.delete_data.success'));
    }
}
