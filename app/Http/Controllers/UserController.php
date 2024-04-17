<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super-Admin')->orderBy('id', 'ASC')->pluck('name');
        
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $collaborator = Collaborator::findOrFail($request->collaborator_id);

        try {
            DB::beginTransaction();
                $password = Str::random(8);

                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'state' => 1,
                ]);
                $collaborator->user()->save($user);

                $user->assignRole($request->role);
            
            DB::afterCommit(function () use ($user, $password) {
                Mail::to($user->email)->send(new userCredentials($user, $password));
            });

            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();

            return redirect()->route('users.create')->with('error', 'Ocurrió un error, y no hemos podido crear el nuevo usuario.');
        }

        return redirect()->route('users')->with('success', 'Nuevo usuario creado exitosamente.');
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
