<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class MeseroController extends Controller
{
   
    public function index()
    {
        //
        $meseros = User::all();
        return view('pages.mesero', compact('meseros'));
    }

    
    public function create(Request $data)
    {
        //
        
        User::create([
            'name' => $data['name'],
            'rol' => $data['rol'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        $meseros = User::all();
        return view('pages.meseros', compact('meseros'));
    }

   
    public function store()
    {
        //
        
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request)
    {
        if (empty($request['passwordUp'])) {
            # code...
            User::where('id',$request['idUserUpdate'])->update([
                'name' => $request['nameUp'],
                'rol' => $request['rolUp'],
                'email' => $request['emailUp']
            ]);
        }else{
            User::where('id',$request['idUserUpdate'])->update([
                'name' => $request['nameUp'],
                'rol' => $request['rolUp'],
                'email' => $request['emailUp'],
                'password' => Hash::make($request['passwordUp']),
            ]);
        }

        $meseros = User::all();
        return view('pages.meseros', compact('meseros'));
    }

    
    public function destroy($id)
    {
        //
    }


    public function __invoke(Request $request)
    {
        //
        $meseros = User::all();
        return view('pages.meseros', compact('meseros'));
    }
}
