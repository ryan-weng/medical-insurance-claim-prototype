<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use App\Remittance;

class DashboardController extends Controller
{
    public function getRemittanceList(Request $request){
      $remittances = Remittance::all();
      return response()->json($remittances);
    }

    public function getNotificationList(Request $request){
      $remittances = Remittance::whereNull('read_at')->get();
      $responses = $remittances->map(function ($item, $key) {
        $item->title = "You receive new remittance request (ID: ".$item->id.')';
        return $item;
      });
      return response()->json($responses);
    }

    public function getRemittanceDetail(Request $request){
      $remittance = Remittance::where('id',$request['id'])->first();
      $remittance->read_at = Carbon::now();
      $remittance->save();

      return response()->json($remittance);
    }

    public function createRemittance(Request $request){
      $v = Validator::make($request->all(), [
        'hospital_id' => 'required',
        'amount' => 'required'
      ]);
      if ($v->passes())
      {
        $remittance = new Remittance;
        $remittance->status = "Approved";
        $remittance->read_at = Carbon::now();
        $remittance->receiver = $request['hospital_id'];
        $remittance->amount = $request['amount'];
        $remittance->save();

        return response()->json([
          'status' => 'OK',
          'message' => 'Successfully stored the data!'
        ], 200);
      }
      else{
        return response()->json([
          'status' => 'FAIL',
          'message' => 'Does not pass the validation process!',
          'data' => $v->messages()
        ], 400);
      }
    }

    public function requestRemittance(Request $request){
      $v = Validator::make($request->all(), [
        'hospital_id' => 'required',
        'amount' => 'required'
      ]);
      if ($v->passes()){
        $remittance = new Remittance;
        $remittance->status = "In Review";
        $remittance->receiver = $request['hospital_id'];
        $remittance->amount = $request['amount'];
        $remittance->save();

        return response()->json([
          'status' => 'OK',
          'message' => 'Successfully stored the data!'
        ], 200);
      }
      else{
        return response()->json([
          'status' => 'FAIL',
          'message' => 'Does not pass the validation process!',
          'data' => $v->messages()
        ], 400);
      }
    }

    public function approveRemittance(Request $request){
      $v = Validator::make($request->all(), [
        'remittance_id' => 'required'
      ]);
      if ($v->passes()){
        $remittance = Remittance::where('id',$request['remittance_id'])->first();
        $remittance->status = "Approved";
        $remittance->save();

        return response()->json([
          'status' => 'OK',
          'message' => 'Successfully stored the data!'
        ], 200);
      }
      else{
        return response()->json([
          'status' => 'FAIL',
          'message' => 'Does not pass the validation process!',
          'data' => $v->messages()
        ], 400);
      }
    }

    public function rejectRemittance(Request $request){
      $v = Validator::make($request->all(), [
        'remittance_id' => 'required'
      ]);
      if ($v->passes()){
        $remittance = Remittance::where('id',$request['remittance_id'])->first();
        $remittance->status = "Rejected";
        $remittance->save();

        return response()->json([
          'status' => 'OK',
          'message' => 'Successfully stored the data!'
        ], 200);
      }
      else{
        return response()->json([
          'status' => 'FAIL',
          'message' => 'Does not pass the validation process!',
          'data' => $v->messages()
        ], 400);
      }
    }

}
