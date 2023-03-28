<?php

namespace App\Http\Controllers;

use App\Models\GuestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guest');
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
            'name' => 'required',
            'id_card_number' => 'required',
            'no_hp' => 'required|unique:guest',
            'email' => 'required|email|unique:guest',
        ]);

        $cekGuest = GuestModel::select('id')
            ->where('id_card_number', '=', $request->id_card_number)
            ->get();
        if (!empty($cekGuest)) {
            return response()->json([
                'success' => false,
                'message' => 'No Identitas sudah didaftarkan, bisa langsung registrasi',
            ], 422);
        }

        $guest = GuestModel::create($request->all());

        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => 'Guest created successfully.',
                'data' => $guest
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create guest.',
            ]);
        }
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
