<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $unit = Unit::select();
            return datatables()->of($unit)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'unit');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Unit', 'unit');
        return view('page.admin-dashboard.unit.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Unit::create($request->all());

        return redirect()->route('admin.unit.index')->with('success', 'Unit has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $data = $this->createMetaPageData($unit->id, 'Unit', 'unit');
        return view('page.admin-dashboard.unit.create-edit', compact('data', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $unit->update($request->all());

        return redirect()->route('admin.unit.index')->with('success', 'Unit has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
            return redirect()->route('admin.unit.index')->with('success', 'Unit has been deleted');
        } catch (\Throwable $th) {
            return redirect()->route('admin.unit.index')->with('error', 'Unit cannot be deleted. Cause : ' . $th->getMessage());
        }
    }
}
