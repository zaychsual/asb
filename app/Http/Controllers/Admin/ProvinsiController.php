<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Provinsi;
use App\User;
use App\DetailUsers;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prov = Provinsi::all();
        // dd($kel);
        return view('admin.prov.index', compact('prov'));
    }

    public function reportMember(Request $request, $id)
    {
        $title = Provinsi::find($id);

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
            $report->where('provinsis.id', $id);
        }
        $report = $report->get();
        
        return view('admin.prov.report',compact('report', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prov.create');
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
            // dd($request);
            $data = Provinsi::create([
                'zona_waktu' => $request->zona_waktu,
                'id_prov' => $request->id_prov,
                'name' => $request->nama,
                'created_by' => \Auth::user()->id,
            ]);
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        return \redirect()->route('admin.provinsi.index')->with('success',\trans('notif.notification.save_data.success'));
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
        $val = Provinsi::find($id);

        return view('admin.prov.edit', compact('val'));
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
            $data = Provinsi::find($id);
            $data->zona_waktu = $request->zona_waktu;
            $data->id_prov = $request->id_prov;
            $data->name = $request->nama;
            $data->updated_by = \Auth::user()->id;
            $data->update();

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        return \redirect()->route('admin.provinsi.index')->with('success',\trans('notif.notification.save_data.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Provinsi::find($id);
        $data->status  = Provinsi::NotActive;
        $data->updated_by = \Auth::user()->id;
        $data->deleted_at = \Carbon\Carbon::now();
        $data->update();

        return \redirect()->route('admin.provinsi.index')->with('success',\trans('notif.notification.delete_data.success'));
    }
}
