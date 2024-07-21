<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;
use App\Models\User;
use App\Models\Absen;
use App\Models\Jabatan;
use App\Models\Lokasi;

class AdminController extends Controller
{
    public function index() {
        $title = "Home";
        $today = date('Y-m-d');
        $absen = Absen::whereDate('created_at',$today)->get();
        $pegawai = User::where('level','Pegawai')->get();
        $jabatan = Jabatan::all();
        return view('admin.index', compact('title','jabatan','pegawai','absen'));
    }
    public function profile()
    {
        $title = 'Profile';
        $admin = User::find(Auth::user()->id);
        return view('admin.profile', compact('title','admin'));
    }
    public function updateProfile(Request $request){
        DB::beginTransaction();
        try {
            if (!empty($request->password)) {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->alamat = $request->alamat;
                $user->password = bcrypt($request->password);
                $user->save();
            }else{
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->alamat = $request->alamat;
                $user->save();
            }
             DB::commit();
            \Session::flash('msg_success','Profile Berhasil Diubah!');
            return Redirect::route('admin.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.profile');
        }
    }

    public function jabatan()
    {
        $title = 'Data Jabatan';
        $jabatan = Jabatan::all();
        return view('admin.jabatan', compact('title','jabatan'));
    }
    public function addJabatan(Request $request) {
        DB::beginTransaction();
        try {
            $jabatan = new Jabatan;
            $jabatan->name = $request->name;
            $jabatan->deskripsi = $request->deskripsi;
            $jabatan->save();

            DB::commit();
            \Session::flash('msg_success','Jabatan Berhasil Ditambah!');
            return Redirect::route('admin.jabatan');
        } catch (\Throwable $th) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.jabatan');
        }
    }
    public function updateJabatan(Request $request) {
        DB::beginTransaction();
        try {
                $jabatan = Jabatan::find($request->id);
                $jabatan->name = $request->name;
                $jabatan->deskripsi = $request->deskripsi;
                $jabatan->save();

            DB::commit();
            \Session::flash('msg_success','Jabatan Berhasil Diubah!');
            return Redirect::route('admin.jabatan');
        } catch (\Throwable $th) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.jabatan');
        }
    }
    public function deleteJabatan($id)
    {
        DB::beginTransaction();
        try {
            $jabatan = Jabatan::where('id',$id)->delete();

            DB::commit();
            \Session::flash('msg_success','Data Jabatan Berhasil Dihapus!');
            return Redirect::route('admin.jabatan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.jabatan');
        }
    }
    public function pegawai()
    {
        $title = 'Data Pegawai';
        $jabatan = Jabatan::all();
        $pegawai = User::where('level','Pegawai')->get();
        return view('admin.pegawai', compact('title','pegawai','jabatan'));
    }
    public function addPegawai(Request $request) {
        DB::beginTransaction();
        try {
            $pegawai = new User;
            $pegawai->name = $request->name;
            $pegawai->email = $request->email;
            $pegawai->no_hp = $request->no_hp;
            $pegawai->alamat = $request->alamat;
            $pegawai->password = bcrypt($request->password);
            $pegawai->jabatan_id = $request->jabatan_id;
            $pegawai->level = 'Pegawai';
            $pegawai->save();

            DB::commit();
            \Session::flash('msg_success','Pegawai Berhasil Ditambah!');
            return Redirect::route('admin.pegawai');
        } catch (\Throwable $th) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pegawai');
        }
    }
    public function updatePegawai(Request $request) {
        DB::beginTransaction();
        try {
            if (!empty($request->password)) {
                $pegawai = User::find($request->id);
                $pegawai->name = $request->name;
                $pegawai->email = $request->email;
                $pegawai->no_hp = $request->no_hp;
                $pegawai->alamat = $request->alamat;
                $pegawai->password = bcrypt($request->password);
                $pegawai->jabatan_id = $request->jabatan_id;
                $pegawai->save();
            }else{
                $pegawai = User::find($request->id);
                $pegawai->name = $request->name;
                $pegawai->email = $request->email;
                $pegawai->no_hp = $request->no_hp;
                $pegawai->alamat = $request->alamat;
                $pegawai->jabatan_id = $request->jabatan_id;
                $pegawai->save();
            }

            DB::commit();
            \Session::flash('msg_success','Pegawai Berhasil Diubah!');
            return Redirect::route('admin.pegawai');
        } catch (\Throwable $th) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pegawai');
        }
    }
    public function deletePegawai($id)
    {
        DB::beginTransaction();
        try {
            $pegawai = User::where('id',$id)->delete();

            DB::commit();
            \Session::flash('msg_success','Data Pegawai Berhasil Dihapus!');
            return Redirect::route('admin.pegawai');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pegawai');
        }
    }
    public function absen()
    {
        $title = 'Data Absen';
        $absen = Absen::all();
        return view('admin.absen', compact('title','absen'));
    }
    public function lokasi()
    {
        $title = 'Data Lokasi';
        $lokasi = Lokasi::find(1);
        return view('admin.lokasi', compact('title','lokasi'));
    }
    public function updateLokasi(Request $request) {
        DB::beginTransaction();
        try {
                $lokasi = Lokasi::find($request->id);
                $lokasi->name = $request->name;
                $lokasi->latitude = $request->latitude;
                $lokasi->longitude = $request->longitude;
                $lokasi->toleransi = $request->toleransi;
                $lokasi->save();

            DB::commit();
            \Session::flash('msg_success','Lokasi Berhasil Diubah!');
            return Redirect::route('admin.lokasi');
        } catch (\Throwable $th) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.lokasi');
        }
    }
}
