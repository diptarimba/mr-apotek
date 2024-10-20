<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            $user = User::
                where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                })
                ->select();
            return datatables()->of($user)
                ->addIndexColumn()
                ->addColumn('role', function($query){
                    return ucfirst($query->getRoleNames()->first());
                })
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query, 'admin');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('page.admin-dashboard.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = json_encode(['admin' => 'Admin', 'cashier' => 'Cashier']);
        $data = $this->createMetaPageData(null, 'Admin', 'admin');
        return view('page.admin-dashboard.admin.create-edit', compact('data', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required|in:admin,cashier'
        ]);

        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password),
            'picture' => asset('assets-dashboard/images/placeholder.png')
        ]));
        $user->assignRole($request->role);
        return redirect()->route('admin.admin.index')->with('success', 'Admin created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $role = json_encode(['admin' => 'Admin', 'cashier' => 'Cashier']);
        $data = $this->createMetaPageData($user->id, 'Admin', 'admin');
        return view('page.admin-dashboard.admin.create-edit', compact('data', 'user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'sometimes',
            'phone' => 'required'
        ]);

        $user->update(array_merge($request->all(), [
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'picture' => $user->picture
        ]));

        return redirect()->route('admin.admin.index')->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if($user->id == auth()->user()->id) {
                throw new \Exception('You cannot delete yourself');
            }
            $user->delete();
            return redirect()->route('admin.admin.index')->with('success', 'Admin Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.admin.index')->with('error', $th->getMessage());
        }
    }
}
