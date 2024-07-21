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

class UserController extends Controller
{
    public function index() {
        $title = "Home";
        return view('pegawai.index', compact('title'));
    }
    public function profile()
    {
        $title = 'Profile';
        $pegawai = User::find(Auth::user()->id);
        return view('pegawai.profile', compact('title','pegawai'));
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
            return Redirect::route('pegawai.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('pegawai.profile');
        }
    }

    public function history()
    {
        $title = 'History';
        $history = Absen::where('user_id',Auth::user()->id)->get();
        return view('pegawai.history', compact('title','history'));
    }
    public function absen()
    {
        $title = 'Absen';
        $today = date('Y-m-d');
        $datang = Absen::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->where('status','Datang')->first();
        $pulang = Absen::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->where('status','Pulang')->first();
        return view('pegawai.absen', compact('title','pulang','datang'));
    }

    public function addAbsen(Request $request){
        // return $request;
        DB::beginTransaction();
        try {
            //get data lokasi puskesmas
            $getLokasi = Lokasi::find(1);
            // Mengonversi dari derajat ke radian
            $earthRadiusMeters = 6371000; // Radius bumi dalam meter (6.371.000 meter)

            $latFrom = deg2rad($request->latitude);
            $lonFrom = deg2rad($request->longitude);
            $latTo = deg2rad($getLokasi->latitude);
            $lonTo = deg2rad($getLokasi->longitude);

            // Menghitung delta dari lat dan lon
            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            // Menghitung jarak menggunakan rumus Haversine
            $a = sin($latDelta / 2) * sin($latDelta / 2) +
                cos($latFrom) * cos($latTo) *
                sin($lonDelta / 2) * sin($lonDelta / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            // Menghitung jarak akhir dalam meter
            $distance = $earthRadiusMeters * $c;
            // return $distance;
            if ($distance > $getLokasi->toleransi) {
                \Session::flash('msg_error','Anda Belum Berada dilokasi absen!');
                return Redirect::route('pegawai.absen');
            }

            $absen = new Absen;
            $absen->status = $request->status;
            $absen->user_id = Auth::user()->id;
            $absen->latitude = $request->latitude;
            $absen->longitude = $request->longitude;
            $absen->save();

            DB::commit();
            \Session::flash('msg_success','Absen Berhasil!');
            return Redirect::route('pegawai.absen');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('pegawai.absen');
        }
    }
}
