<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari query string
        $searchName = $request->input('name');
        
        // Query untuk mendapatkan kategori sesuai dengan outlet_id dan nama kategori jika ada pencarian
        $staffs = User::where('role_id', 2)
            ->when($searchName, function($query) use ($searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->paginate(10);

        // Menambahkan parameter pencarian pada pagination link
        $staffs->appends(['name' => $searchName]);

        return view('dashboard.staff.index', [
            'staffs' => $staffs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users|string|max:255',
            'phone' => [
                'required',
                'unique:users',
                'regex:/^[0-9]+$/',
                'string',
                'min:10',
                'max:15',
            ],
        ]);

        $validateData['role_id'] = 2;
        $validateData['password'] = bcrypt('12345678'); //default password
        User::create($validateData);

        return redirect(route('staff.index'))->with('success', 'New Staff has been added!');
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
        $user = User::findOrFail($id);
        return view('dashboard.staff.edit', compact('user'));
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
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($id),
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:15',
                Rule::unique('users', 'phone')->ignore($id),
            ],
        ]);

        User::where('id', $id)->update($validateData);

        return redirect(route('staff.index'))->with('success', 'Staff has been updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('staff.index'))->with('success', 'Staff has been deleted!');
    }

    public function resetPassword(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        
        $staff->update([
            'password' => bcrypt('12345678'),
        ]);

        return redirect()->route('staff.index')->with('success', 'Password has been reset successfully!');
    }

}
