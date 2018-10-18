<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Hospital;
use App\Claim;
use App\Claimable;
use App\Policy;
use App\User;

class DashboardController extends Controller
{
    public function getHospitalList(){
      $hospitals = Hospital::all();
      return response()->json($hospitals);
    }

    public function createHospital(Request $request){
      $v = Validator::make($request->all(), [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required'
      ]);
      if ($v->passes())
      {
        $hospitalData = $request->only(['name','address','phone']);

        $hospital = new Hospital;
        $hospital->name = $request['name'];
        $hospital->address = $request['address'];
        $hospital->phone = $request['phone'];
        $hospital->save();

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

    public function getClaimableList(){
      $claimables = Claimable::all();
      return response()->json($claimables);
    }

    public function createClaimable(Request $request){
      $v = Validator::make($request->all(), [
        'name' => 'required',
        'amount' => 'required',
        'max_count' => 'required'
      ]);
      if ($v->passes())
      {
        $claimable = new Claimable;
        $claimable->name = $request['name'];
        $claimable->amount = $request['amount'];
        $claimable->max_count = $request['max_count'];
        $claimable->save();

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

    public function getInsurancePolicyList(){
      $policies = Policy::all();
      return response()->json($policies);
    }

    public function createInsurancePolicy(Request $request){
      $v = Validator::make($request->all(), [
        'name' => 'required',
        'max_claimable_amount' => 'required',
        'claimables' => 'required'
      ]);
      if ($v->passes())
      {
        $insurance = new Policy;
        $insurance->name = $request['name'];
        $insurance->amount = $request['max_claimable_amount'];
        $insurance->save();

        $insurance->claimables()->attach($request['claimables']);

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

    public function getClaimRequestList(){
      $claims = Claim::with(['user', 'hospital', 'policy'])->get();
      return response()->json($claims);
    }

    public function createClaimRequest(Request $request){
      $v = Validator::make($request->all(), [
        'user_id' => 'required',
        'hospital_id' => 'required',
        'insurance_policy_id' => 'required',
        'hospital_department' => 'required',
        'medical_history_number' => 'required'
      ]);
      if ($v->passes())
      {
        $claim = new Claim;
        $claim->user_id = $request['user_id'];
        $claim->hospital_id = $request['hospital_id'];
        $claim->insurance_policy_id = $request['insurance_policy_id'];
        $claim->hospital_department = $request['hospital_department'];
        $claim->medical_history_number = $request['medical_history_number'];
        $claim->save();

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

    public function getUserClaimRequestList(Request $request){
      $claims = auth()->user()->claims()->with(['user', 'hospital', 'policy'])->get();
      return response()->json($claims);
    }

    public function getUserInsurancePolicyList(Request $request){
      $policies = auth()->user()->policies;
      return response()->json($policies);
    }

    public function getClaimRequestDetailById(Request $request){
      $claim = Claim::where('id',$request['id'])->with(['user', 'hospital', 'policy'])->first();
      return response()->json($claim);
    }

    public function rejectClaimRequestById(Request $request){
      $v = Validator::make($request->all(), [
        'user_id' => 'required',
        'hospital_id' => 'required',
        'insurance_policy_id' => 'required',
        'hospital_department' => 'required',
        'medical_history_number' => 'required'
      ]);
      if ($v->passes())
      {
        $claim = Claim::where('id',$request['id'])->first();
        $claim->status = "Rejected";
        $claim->save();
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

    public function approveClaimRequestById(Request $request){

    }

    public function getInsuranceDetail(Request $request){
      $insurance = Policy::where('id',$request['id'])->with('claimables')->first();
      return response()->json($insurance);
    }

    public function getSystemClaimNotificationList(Request $request){
      $claims = Claim::whereNull('read_at_system')->get();
      $response = $claims->map(function ($item, $key) {
        $item->title = "You receive new claim request (ID: ".$item->id.')';
        return $item;
      });
      return response()->json($response);
    }

    public function getAppClaimNotificationList(Request $request){
      $claims = Claim::whereNull('read_at_app')
        ->where('status', '<>', 'In Review')
        ->whereHas('user', function ($query) use ($request) {
            $query->where('id', '=', $request['id']);
        })
        ->get();
        $response = $claims->map(function ($item, $key) {
          $item->title = "Your claim request (ID: ".$item->id.') is reviewed.';
          return $item;
        });
        return response()->json($response);
    }
}
