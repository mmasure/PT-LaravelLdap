<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var User | null
     */
    private $user;

    /**
     * @var string[]
     */
    private $nameRouteEnable = [
                'new','store','list'
            ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        if( $id = Route::current()->parameter('idUser') ) {
            $this->user = User::find($id);

            if( !$this->user->exists() ) {
                abort(404);
            }
        } elseif(!Str::contains(Route::current()->getName(),$this->nameRouteEnable)) {
            abort(404);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function list()
    {
        $users = User::all();
        return view('users.list')->with([
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->password = bcrypt($request->password);
        $request->username = mb_strtolower($request->username);
        $request->name = mb_strtolower($request->username);

        $this->user = User::create($request->except('_token'));

        return new JsonResponse([
            'statut' => 200
        ]);
    }

    public function update(Request $request)
    {
        if($request->has('password')){
            $request->password = bcrypt($request->password);
        }
        $request->username = mb_strtolower($request->username);
        $request->name = mb_strtolower($request->username);

        $this->user->update($request->except('_token'));

        dd($request->all());

        return new JsonResponse([
            'statut' => 200
        ]);
    }

    public function destroy()
    {
        if($this->user->exists()) {
            $this->user->delete();
        }
    }
}
