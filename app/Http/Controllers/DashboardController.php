<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departament;
use App\Models\Document;
use App\Models\Folder;

class DashboardController extends Controller
{
    public function index(){
        $audits=\DB::table('audits')->get();
        
        $usuarios = User::all()->groupBy('id')->count();
        $departamentos = Departament::all()->groupBy('id')->count();
        $documentos = Document::all()->groupBy('id')->count();
        $carpetas = Folder::all()->groupBy('id')->count();

        
        return view('admin.Dashboard.index')
        ->with(compact('usuarios'))
        ->with(compact('departamentos'))
        ->with(compact('documentos'))
        ->with(compact('carpetas'))
        ->with(compact('audits'))
        ;
    }
}
