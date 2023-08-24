<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "I am in member controller index function";
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "I am in member controller create function";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return "I am in member controller store function";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return "I am in member controller show function";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return "I am in member controller edit function";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return "I am in member controller update function";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return "I am in member controller idestroy function";
    }
}
