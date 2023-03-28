<?php

namespace App\Http\Controllers;

use App\Models\GuestModel;
use App\Models\RegistrationModel;
use App\Models\StaffModel;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('registrasi');
    }

    public function search_staff(Request $request)
    {
        $data = StaffModel::select("id", "name")
            ->where("name", "LIKE", "%{$request->str}%")
            ->get('query');
        return response()->json($data);
    }

    public function search_guest(Request $request)
    {
        $data = GuestModel::select("id", "name")
            ->where("name", "LIKE", "%{$request->str}%")
            ->orWhere("id_card_number", "LIKE", "%{$request->str}%")
            ->get('query');
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_guest' => 'required',
            'id_staff' => 'required',
        ]);

        $data = RegistrationModel::create([
            'guest_id' => $request->id_guest,
            'staff_id' => $request->id_staff,
            'regis_time' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration succesful',
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
