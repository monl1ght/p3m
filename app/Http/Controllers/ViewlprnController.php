<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewlprnController extends Controller
{

    public function upp3m(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = p3mModel::with('anggotap3m');
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = p3mModel::where('user_id', $user->id)
                ->with('anggotap3m');
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();


        // $penelitians = p3mModel::where('user_id', $user->id)
        //     // ->orWhereNull('user_id')
        //     ->orderBy('created_at', 'desc')
        //     ->with('anggotap3m')
        //     ->get();
        // dd($penelitians);
        return view('plppm.lpengabdian', compact('user', 'penelitians', 'pagetitle'));
    }

    public function ajuanpeneliti(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Penelitian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id);
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = ajuan_penelitianModel::with('anggotap3m');
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = ajuan_penelitianModel::where('user_id', $user->id)
                ->with('anggotap3m');
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        // dd($penelitians);
        return view('plppm.lpeneleitian', compact('user', 'penelitians', 'pagetitle'));
    }

    public function kpengabdianp3m(Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = kum_pengabdianModel::with('anggotap3m');
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = kum_pengabdianModel::where('user_id', $user->id)
                ->with('anggotap3m');
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        return view('plppm.kpengabdian', compact('user', 'pagetitle', 'penelitians'));
    }

    public function kpeneliti(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Laporan Penelitian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id);
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = kum_penelitianModel::with('anggotap3m');
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = kum_penelitianModel::where('user_id', $user->id)
                ->with('anggotap3m');
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        // dd($penelitians);
        return view('plppm.kpenelitian', compact('user', 'penelitians', 'pagetitle'));
    }


    //UPDATE STATUS P3M 
    //PEGABDIAN
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approve,proses,non-approve'
        ]);

        $pengajuan = p3mModel::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->save();

        // dd($request->all());
        return redirect()->route('plppm.lpengabdian')->with('success', 'Status updated');
        // return redirect()->back()->with('success', 'Status berhasil diubah ke ' . $request->status);
    }


    //PENELITIAN
    public function updateStatusPen(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approve,proses,non-approve'
        ]);

        $pengajuan = ajuan_penelitianModel::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->save();

        // dd($request->all());
        return redirect()->route('plppm.lpeneleitian')->with('success', 'Status updated');
        // return redirect()->back()->with('success', 'Status berhasil diubah ke ' . $request->status);
    }

    //둘다
    public function updateStatuskump(Request $request, $tipe, $id)
    {
        $request->validate([
            'status' => 'required|in:approve,proses,non-approve'
        ]);

        // Tentukan model berdasarkan tipe
        switch ($tipe) {
            case 'kum_penelitian':
                $pengajuan = kum_penelitianModel::findOrFail($id);
                $redirect = 'plppm.kpenelitian';
                break;

            case 'kum_pengabdian':
                $pengajuan = kum_pengabdianModel::findOrFail($id);
                $redirect = 'plppm.kpengabdian';
                break;

            default:
                return redirect()->back()->with('error', 'Tipe tidak valid');
        }

        // Update status
        $pengajuan->status = $request->status;
        $pengajuan->save();

        return redirect()->route($redirect)->with('success', 'Status berhasil diubah ke ' . $request->status);
    }


    public function dajupeneliti($tipe, $id, Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Proposal';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'ajupengab':
                $data = p3mModel::with('anggotap3m')->findOrFail($id);
                break;
            case 'ajupenel':
                $data = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
                break;
            // case 'kpenel':
            //     $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            // case 'kpengab':
            //     $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            default:
                abort(404);
        }
        if ($user->role != 'admin' && $data->user_id != $user->id) {
            abort(403, 'Kamu tidak boleh mengakses data ini.');
        }

        // searching data
        if ($request->get('search')) {
            $keyword = $request->get('search');

            if ($tipe === 'ajupengab') {
                $data = p3mModel::with('anggotap3m')
                    ->where('id', $id)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->firstOrFail();
            } elseif ($tipe === 'ajupenel') {
                $data = ajuan_penelitianModel::with('anggotap3m')
                    ->where('id', $id)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->firstOrFail();
            }
        }

        return view('detail.detail', [
            'penelitians' => $data,
            'pagetitle' => $pagetitle,
            'tipe' => $tipe,
            'user' => $user,
            'layout' => ($user->role === 'admin') ? 'layout.main' : 'layout.doslayout'
        ]);
    }

    public function kumpengneli($tipe, $id)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Laporan';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'kpengeabdian':
                $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
                break;
            case 'kpeneliti':
                $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
                break;
            // case 'kpenel':
            //     $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            // case 'kpengab':
            //     $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            default:
                abort(404);
        }

        return view('detail.detailk', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'user' => $user,
            'pagetitle' => $pagetitle,
            'layout' => ($user->role === 'admin') ? 'layout.main' : 'layout.doslayout'
        ]);
    }
}
