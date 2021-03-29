<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MapData as Mdata;
use App\Http\Requests\ApiRideStatus as ApiReq;

class RideStatus extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(ApiReq $request)
    {
        $ra_data=$request->validated();
        if($ra_data){
            $ride_data=false;
            $source=$ra_data['source']; //user origin
            $destination=$ra_data['destination']; // user dastination
            $get_store_data=Mdata::select('source','destination')->get()->toArray();
            $g_data=Mdata::select('name','mobile','email','source','destination')->where([['source','=',$ra_data['source']],['destination','=', $ra_data['destination']]])->get(); // match exact data with input data
            if(!$g_data->isEmpty()){
                $ride_result=$g_data;
                $ride_data=true;
            }
            else{
                foreach($get_store_data as $key => $value){
                    $all_lat=$this->getAllPlaceList($value['source'], $value['destination']);
                    $match_data=array_intersect($all_lat,[$source, $destination]);
                    if ($match_data) {
                        $ride_result=$match_data;
                        $ride_data=true;
                        break;
                    }

                }
               // var_dump($get_store_data);

            }

            if($ride_data){
                $response = response()->json([
                    'message' => 'RIDE_FOUND',
                    'data' => $ride_result,
                ], 200);
            }
            else{
                $response=response()->json([
                    'message'=>'NO_RIDE_FOUND',
                    'data'=> ["NF"=>"sorry there is no ride found your search"]
                ],201);
            }
            return $response;
        }

        //return MapData::all();
    }

    public function getAllPlaceList($source, $destination){

        return $data=[
            '17.439730,78.498470',
            '17.439730,78.498530',
            '17.439730,78.498530',
            '17.439730,78.498530',
            '17.439730,78.498530',
            '17.439730,78.498530',
            '17.439731,78.498531',

        ];

    }
}
