<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UsuarioFormRequest $request){

            if ($request){
                $query = trim($request->get('searchText'));
                $usuarios = DB::table('users')->where('name','LIKE','%'.$query.'%')
                    ->orderBy('id','desc')
                    ->paginate(7);

                return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
        }
    }

    public function create(){
        return view('seguridad.usuario.create');
    }

    public function store(UsuarioFormRequest $request){
        $usuario = new User;
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
        $usuario->save();

        return redirect('seguridad/usuario');
    }

    public function edit($id){
        return view('seguridad.usuario.edit',["usuario"=>User::findOrFile($id)]);
    }

    public function update(UsuarioFormRequest $request, $id){
        $usuario = User::findOrFile($id);
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
        $usuario->update();

        return redirect('seguridad/usuario');
    }
    public function destroy($id){
        $usuario = DB::table('users')->where('id','=',$id)->delete();
        return redirect('seguridad/usuario');
    }

}
