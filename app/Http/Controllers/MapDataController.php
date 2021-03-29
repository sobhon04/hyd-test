<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MapDataRequest as MDRequest;
use App\Models\MapData;

class MapDataController extends Controller
{
    public function index(Request $request){
        return view('add-details');
    }

    public function store(MDRequest $request){
        $rData=$request->validated();
        if($rData){
            $SData= new MapData();
            $SData->name=$rData['name'];
            $SData->mobile=$rData['mobile'];
            $SData->email=$rData['email'];
            $SData->source=$rData['source'];
            $SData->destination=$rData['destination'];
            $data_saved=$SData->save();
            if($data_saved){
                session()->flash('status', 'Successfully saved routes details');

            }else{
                session()->flash('status', 'Data cannot saved please contact administrator');
            }
            return redirect()->back();
        }
    }
}
