<?php

namespace App\Http\Controllers;

use App\Models\M_news;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataTableController extends Controller
{

    public function clientside(Request $request)

    {

        $user = Auth::user();
        $data = new M_news();

        if ($request->get('search')) {
            $data = User::where('name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('datatable.clientside', compact('data', 'request', 'user'));
    }
    public function servelside(Request $request)
    {
        $data = new User;

        if ($request->get('search')) {
            $data = User::where('name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('index', compact('data', 'request'));
    }
}
