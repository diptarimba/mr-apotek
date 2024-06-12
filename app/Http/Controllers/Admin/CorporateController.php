<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CorporateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $corporates = Corporate::select();
            return datatables()->of($corporates)
            ->addIndexColumn()
            ->addColumn('picture', function ($corporate) {
                return '<img src="'.$corporate->image.'" class="img-thumbnail" width="100" height="100"/>';
            })
            ->addColumn('action', function ($corporate) {
                return $this->getActionColumn($corporate, 'corporate');
            })
            ->rawColumns(['action', 'picture'])
            ->make(true);
        }

        return view('page.admin-dashboard.corporate.index');
    }

    public function addResetPassword(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Corporate', 'corporate');
        return view('page.admin-dashboard.corporate.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        $dataPost = $request->all();

        if ($request->hasFile('image')) {
            // dd("image");
            $image = $request->file('image');
            $image->storeAs('public/corporate', $image->hashName(), 'public');
            $dataPost = array_merge($dataPost, ['image' => asset('storage/public/corporate/' . $image->hashName())]);

        }

        $corporate = Corporate::create($dataPost);

        $password = Str::random(10);
        $admin = "admin_" . Str::random(10);

        $admin_corporate = $corporate->user_corporate()->create([
            'name' => "Admin " . $corporate->name,
            'email' => $corporate->email,
            'password' => bcrypt($password),
            'username' => $admin,
            'phone' => $corporate->phone,
            'picture' => $corporate->image,
            'corporate_admin' => true
        ]);

        $admin_corporate->assignRole('user_corporate');

        return redirect()->route('admin.corporate.index')
        ->with('success', 'Corporate created successfully')
        ->with('corporate_name',  $corporate->name)
        ->with('auth_username',  $admin)
        ->with('auth_password',  $password);
    }

    /**
     * Display the specified resource.
     */
    public function show(Corporate $corporate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Corporate $corporate)
    {
        $data = $this->createMetaPageData($corporate->id, 'Corporate', 'corporate');
        return view('page.admin-dashboard.corporate.create-edit', compact('data', 'corporate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Corporate $corporate)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png|max:2048',
        ]);

        $dataPost = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/corporate', $image->hashName(), 'public');
            $dataPost = array_merge($dataPost, ['image' => asset('storage/public/corporate/' . $image->hashName())]);
        }

        $corporate->update($dataPost);

        return redirect()->route('admin.corporate.index')->with('success', 'Corporate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Corporate $corporate)
    {
        try {
            $corporate->delete();
            $corporate->user_corporate()->delete();
            return redirect()->route('admin.corporate.index')->with('success', 'Corporate deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
