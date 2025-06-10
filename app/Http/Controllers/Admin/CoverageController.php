<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Coverage;
use Validator;

class CoverageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getList(){
        $states = Coverage::where('ctype', 0)->get();
        $data = ['states' => $states];
        return view('admin.coverage.list', $data);
    }

    public function postCoverageStateAdd(Request $request){
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'Es requerido el nombre de la cobertura'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger'); 
        else:
            $coverage = new Coverage;
            $coverage->ctype = '0';
            $coverage->state_id = '0';
            $coverage->name = e($request->input('name'));
            $coverage->price = '0';
            $coverage->days = $request->input('days');

            if($coverage->save()):
                return back()->with('message','Guardado con exito')->with('typealert','success');
            endif;
        endif;
    }

    public function getCoverageEdit($id){
        $coverage = Coverage::findOrFail($id);
        $data = ['coverage' =>$coverage];
        return view('admin.coverage.edit', $data);
    }

    public function getCoverageDelete($id){
        $coverage = Coverage::findOrFail($id);    
        if($coverage->delete()):
            return back()->with('message','Eliminado con exito')->with('typealert','success');
        endif;
    }
}
