<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use app\Models\cat_role;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Auth;
use Hash;
use DB;
use Str;


class UsersController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        return view('pages.config.users.index', ['active' => 'usuarios']);
    }

    public function index_perfil(Request $request){

        return view('pages.config.perfil.index', ['active' => 'perfil',
        'sessions' => $this->sessions($request)->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $store = $request->all();

        $cadena = 'Usuario registrado | ';
        if($store['id'] != null){
            $validator = Validator::make($request->all(),[
                'email' => [ 
                    'required',
                    'email',
                    Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($request->id),
                ],
                'password_plain' => ['required',
                    'string',
                    'min:8', 
                ], 
            ], [
                'email.unique' => 'El correo ya está en uso.',
                'min' => 'La contraseña debe tener al menos :min caracteres.',
                'regex' => 'El formato de la contraseña no es válido.',
            ]);
            $cadena = 'Usuario editado | ';
        }else{
            $validator = Validator::make($request->all(),[
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->whereNull('deleted_at' ),
                ],
                'password_plain' => ['required',
                    'string',
                    'min:8', 
                ],            
            ]
            , [
                'email.unique' => 'El correo ya está en uso.',
                'min' => 'La contraseña debe tener al menos :min caracteres.',
                'regex' => 'El formato de la contraseña no es válido.',
            ]);
            $store['api_token'] = Str::random(60);
        }

        if ($validator->fails()) {
            return response()->json(
                [
                    'respuesta' => false,
                    'mensaje' => $validator->errors()
                ]
            );
        }

        if($store['password_plain']) {
            $store['password'] = Hash::make($store['password_plain']);
        }

        $user = User::updateOrCreate(['id' => $store['id'] ?? null],$store);

        $user->roles()->attach(cat_role::where('id', $store['rol'])->first());
        $cadena .= $store['name']." ".$store['apellidos']." - Rol ".$store['rol']." - Email ".$store['email'];

        \Notificaciones::agregarLog($cadena, $user->id, "users");
        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Accion realizada correctamente"
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request){
        
        return response()->json([
            'status' => true,
            'usuario' => User::find($id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $user = User::withTrashed()->find($id);
        $user ->delete();
        \Notificaciones::agregarLog('Registro eliminado desde Mi empresa - Usuarios ', $id, "users");
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function getUsuarios(){
        if($user = User::where('rol' ,'<>', 0)->get()){
            return response()->json([
                'data' => $user
            ]);
        }else{
            return response()->json([
                'status' => false,
            ], 200);
        }
    }

    public function actualizar(Request $request){
        
        $user = User::where('id', $request->id)->update(['activado'=> $request->activado]);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Accion realizada correctamente"
            ]
        );
    }

    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function logoutOtherBrowserSessions(StatefulGuard $guard)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $guard->logoutOtherDevices($this->password);

        $this->deleteOtherSessionRecords();

        request()->session()->put([
            'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        $this->confirmingLogout = false;

        $this->emit('loggedOut');
    }

    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
