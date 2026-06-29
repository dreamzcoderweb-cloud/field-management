<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        /* Log::debug('An informational message.');*/

        $file = $request->file('file');
        $clientId = $request->clientId;
        $remarks = $request->remarks;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $address = $request->address;

        if ($file == null) {
            return Error::response('File is required');
        }

        if ($clientId == null) {
            return Error::response('Client Id is required');
        }

        if ($remarks == null) {
            return Error::response('Remarks is required');
        }

        if ($latitude == null) {
            return Error::response('Latitude is required');
        }

        if ($longitude == null) {
            return Error::response('Longitude is required');
        }

        $client = Client::find($clientId);

        if ($client == null) {
            return Error::response('Client not found');
        }

        $attendance = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::now())
            ->first();

        if ($attendance == null) {
            return Error::response('Attendance not found');
        }

        // $fileName = time() . '_' . $file->getClientOriginalName();
        // $filePath = $file->storeAs('uploads/Visits', $fileName, 'public');
         $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/uploads/Visits'), $fileName);
        $filePath = 'uploads/Visits/' . $fileName;
       // Storage::put($filePath, file_get_contents($file));

        Visit::create([
            'client_id' => $client->id,
            'attendance_id' => $attendance->id,
            'user_id' => auth()->user()->id,
            'remarks' => $remarks,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'created_by_id' => auth()->user()->id,
            'img_url' => '/storage/' . $filePath
        ]);

        return Success::response('Visit created successfully');

    }

    public function getVisitsCount()
    {
        $todaysVisits = Visit::where('created_by_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::now())
            ->count();

        $totalVisits = Visit::where('created_by_id', auth()->user()->id)
            ->count();

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => [
                'todaysVisits' => $todaysVisits,
                'totalVisits' => $totalVisits
            ]
        ]);
    }

    public function getHistory(Request $request)
    {
        $dateString = $request->date;

        $visits = [];

        if ($dateString == null) {
            $visits = Visit::where('created_by_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        } else {
            $date = Carbon::parse($dateString)->format('Y-m-d');
            $visits = Visit::where('created_by_id', auth()->user()->id)
                ->whereDate('created_at', new DateTime($date))
                ->get();
        }

        $result = [];

        foreach ($visits as $visit) {
            $result[] = [
                'id' => $visit->id,
                'clientAddress' => $visit->address,
                'clientName' => $visit->client->name,
                'visitImage' => $visit->img_url,
                'latitude' => floatval($visit->latitude),
                'longitude' => floatval($visit->longitude),
                'visitRemarks' => $visit->remarks,
                'visitDateTime' => $visit->created_at->format('d-m-Y h:i: A'),
                'clientContactPerson' => $visit->client->contact_person,
                'clientEmail' => $visit->client->email,
                'clientPhoneNumber' => $visit->client->phone,
            ];
        }

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $result
        ]);
    }
}
