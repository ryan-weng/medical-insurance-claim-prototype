<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Patient;
use App\MedicalHistoryItem;
use App\MedicalHistory;
use App\Department;
use App\Doctor;
use App\Treatment;
use App\MedicalRecord;
use App\MedicalRecordTreatment;
use App\Diagnostic;
use App\Reservation;
use App\Room;
use App\PaymentReceipt;

class DashboardController extends Controller
{
  public function getPatients(){
    $patients = Patient::all();
    return response()->json($patients);
  }

  public function createPatient(Request $request){
    $v = Validator::make($request->all(), [
      'name' => 'required',
      'id_type' => 'required',
      'id_number' => 'required',
      'birthday' => 'required',
      'gender' => 'required',
      'phone' => 'required',
      'address' => 'required'
    ]);
    if ($v->passes())
    {
      $patientData = $request->only(['name','id_type','id_number','birthday','gender','phone','address']);
      $patient = new Patient;
      $patient->id_type = $patientData['id_type'];
      $patient->id_number = $patientData['id_number'];
      $patient->name = $patientData['name'];
      $patient->birthday = $patientData['birthday'];
      $patient->gender = $patientData['gender'];
      $patient->phone = $patientData['phone'];
      $patient->address = $patientData['address'];
      if ($patient->save()){
        return response()->json([
          'status' => 'OK',
          'message' => 'Successfully stored the data!'
        ], 200);
      }
      else {
        return response()->json([
          'status' => 'FAIL',
          'message' => 'Failed to store the data!'
        ], 200);
      }
    }
    else{
      return response()->json([
        'status' => 'FAIL',
        'message' => 'Does not pass the validation process!',
        'data' => $v->messages()
        ], 200);
    }
  }

  public function getPatientDetail(Request $request){
    $patient = Patient::where('id',$request['id'])->first();
    $response = [
      '身分證類型' => $patient->id_type,
      '身分證號碼' => $patient->id_number,
      '姓名' => $patient->name,
      '性別' => $patient->gender,
      '出生日期' => $patient->birthday,
      '現在地址' => $patient->address
    ];
    return response()->json($response);
  }

  public function getPatientMedicalHistory(Request $request){
    $patient = Patient::where('id',$request['id'])->first();
    $response = [];
    foreach($patient->medical_history as $item){
      $response[$item->item->name] = [
        'value' => $item->value,
        'unit' => $item->item->unit,
        'description' => $item->description,
        'created_date' => $item->created_at->toDateTimeString()
      ];
    }
    return response()->json($patient->medical_history);
  }

  public function getPatientMedicalRecord(Request $request){
    $records = MedicalRecord::where('type','Outpatient')
      ->whereHas('patient', function($q) use ($request) {
        $q->where('id',$request['id']);
      })
      ->with(['diagnostic','diagnostic.doctor', 'diagnostic.doctor.department'])->get();
    return response()->json($records);
  }

  public function getMedicalHistoryItem(){
    $items = MedicalHistoryItem::all();
    return response()->json($items);
  }

  public function createMedicalHistory(Request $request){
    foreach($request['data'] as $data){
      $history = new MedicalHistory;
      $history->value = $data['value'];
      if (isset($data['description']))
        $history->description = $data['description'];
      $history->patient_id = $request['id'];
      $history->item_id = $data['id'];
      $history->save();
    }
    return response()->json(true);
  }

  public function getDepartmentsList(){
    $departments = Department::all()->toArray();
    return response()->json($departments);
  }

  public function getDoctorsListByDepartmentId(Request $request){
    $doctors = Doctor::where('department_id',$request['id'])->get()->toArray();
    return response()->json($doctors);
  }

  public function getTreatmentsList(){
    $treatments = Treatment::with('category')->get();
    return response()->json($treatments);
  }

  public function createOutpatient(Request $request){
    $v = Validator::make($request->all(), [
      'doctor_id' => 'required',
      'patient_id' => 'required',
      'date' => 'required'
    ]);
    if ($v->passes())
    {
      $outpatientData = $request->only(['doctor_id','patient_id','date']);

      $medicalRecord = new MedicalRecord;
      $medicalRecord->type = 'Outpatient';
      $medicalRecord->patient_id = $outpatientData['patient_id'];
      $medicalRecord->save();

      $diagnostic = new Diagnostic;
      $diagnostic->doctor_id = $outpatientData['doctor_id'];
      $diagnostic->outpatient_date = $outpatientData['date'];

      $medicalRecord->diagnostic()->save($diagnostic);

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
        ], 200);
    }
  }

  public function updateOutpatientDiagnosis(Request $request){
    $v = Validator::make($request->all(), [
      'record_id' => 'required',
      'diagnostic' => 'required',
      'complaint' => 'required'
    ]);
    if ($v->passes())
    {
      $diagnosticData = $request->only(['record_id','diagnostic','complaint']);

      $medicalRecord = MedicalRecord::where('id', $diagnosticData['record_id'])->first();
      $medicalRecord->diagnostic()->update([
        'diagnostic' => $diagnosticData['diagnostic'],
        'complaint' => $diagnosticData['complaint']
      ]);
      $medicalRecord->save();

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
        ], 200);
    }
  }

  public function getPatientDiagnostic(Request $request){
    $record = MedicalRecord::where('id', $request['id'])->with(['diagnostic','reservation','reservation.room'])->first();
    return response()->json($record);
  }

  public function getOutpatientsList(){
    $record = MedicalRecord::where('type','Outpatient')->with(['diagnostic','patient','diagnostic.doctor','diagnostic.doctor.department'])->get();
    return response()->json($record);
  }

  public function getAvailableRooms(Request $request){
    $start_date = $request['starting_date'];
    $end_date = $request['ending_date'];
    $record = Room::whereDoesntHave('reservations', function($q) use ($start_date, $end_date){
      $q->whereBetween('starting_date', [$start_date,$end_date])
        ->whereBetween('ending_date', [$start_date,$end_date]);
    })->get();
    return response()->json($record);
  }

  public function getPatientDetailByOutpatientId(Request $request){
    $record = MedicalRecord::where('id',$request['id'])->first();
    $response = [
      '身分證類型' => $record->patient->id_type,
      '身分證號碼' => $record->patient->id_number,
      '姓名' => $record->patient->name,
      '性別' => $record->patient->gender,
      '出生日期' => $record->patient->birthday,
      '現在地址' => $record->patient->address
    ];
    return response()->json($response);
  }

  public function createInpatient(Request $request){
    $v = Validator::make($request->all(), [
      'room_id' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
      'diagnostic_id' => 'required'
    ]);
    if ($v->passes())
    {
      $inpatientData = $request->only(['room_bed','start_date','end_date','diagnostic_id', 'room_id']);
      // dd($inpatientData);
      $medicalRecord = Diagnostic::where('id', $inpatientData['diagnostic_id'])->first()->medical_record;

      $reservation = new Reservation;
      $reservation->starting_date = $inpatientData['start_date'];
      $reservation->ending_date = $inpatientData['end_date'];
      $reservation->room_id = $inpatientData['room_id'];

      $medicalRecord->reservation()->save($reservation);

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
        ], 200);
    }
  }

  public function getInpatientList(Request $request){
    $inpatient = MedicalRecord::whereHas('reservation')->with(['diagnostic','patient','reservation', 'reservation.room'])->get();

    return response()->json($inpatient);
  }

  public function getInpatientListByPatientId(Request $request){
    $inpatients = MedicalRecord::whereHas('patient', function($q) use ($request) {
      $q->where('id','=',$request['id']);
    })->whereHas('reservation')->with(['diagnostic','patient','reservation','reservation.room'])->get();
    return response()->json($inpatients);
  }

  public function createMedicalTreatment(Request $request){
    $v = Validator::make($request->all(), [
      'record_id' => 'required',
      'treatment_id' => 'required',
      'amount' => 'required',
    ]);
    if ($v->passes())
    {
      $treatmentData = $request->only(['record_id','treatment_id','amount']);
      $medicalRecordTreatment = new MedicalRecordTreatment;
      $medicalRecordTreatment->medical_record_id = $treatmentData['record_id'];
      $medicalRecordTreatment->treatment_id = $treatmentData['treatment_id'];
      $medicalRecordTreatment->amount = $treatmentData['amount'];
      $medicalRecordTreatment->save();

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
        ], 200);
    }
  }

  public function getTreatmentListByPatientId(Request $request){
    $medicalrecordtreatments = MedicalRecord::whereHas('patient', function($q) use ($request){
      $q->where('id',$request['id']);
    })->with('treatments','treatments.treatment')->get();
    return response()->json($medicalrecordtreatments);
  }

  public function checkIn(Request $request){
    $reservation = Reservation::where('id',$request['reservation_id'])->first();
    $reservation->enter_date = $request['enter_date'];
    $reservation->save();
    return response()->json([
      'status' => 'OK',
      'message' => 'Successfully stored the data!'
    ], 200);
  }

  public function checkOut(Request $request){
    $reservation = Reservation::where('id',$request['reservation_id'])->first();
    $reservation->leave_date = $request['leave_date'];
    $reservation->save();

    return response()->json([
      'status' => 'OK',
      'message' => 'Successfully stored the data!'
    ], 200);
  }

  public function getPatientPaymentRecord(Request $request){
    $receipts = Patient::where('id',$request['id'])->first()->payment_receipts;
    return response()->json($receipts);
  }

  public function getPaymentDetailByReceiptId(Request $request){
    $receipt = PaymentReceipt::where('id',$request['id'])->get();
    return response()->json($receipt);
  }
}
