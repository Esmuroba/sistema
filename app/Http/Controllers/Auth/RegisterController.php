<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Collaborator;
use App\Mail\MyTestMail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PDF;






class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'/* , 'confirmed' */],
        ]);
    }

    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function index()
    {
        return view('auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    

    public function store(Request $request)
    {
        // $request->validate ([
        //     'email' => 'required',
        //     'password' => [
        //         'required',
        //         Password::min(8)
        //             ->mixedCase()
        //             ->numbers()
        //             ->uncompromised()
        //     ],
        // ]);

       
        $rules = array(
            'email'            => ['required','email'],     
            'password'         => ['required',Password::min(8)
                                                           ->mixedCase('letras mayusculas')
                                                           ->numbers()
                                                           ->uncompromised()
                                   ],
        );
        $customMessages = array(
            'email.required' => 'El email no se admite vacío',
            'password.min' => 'Mínimo 8 caracteres',
            'password.required' => 'La contraseña es requerida',
        );
        
        $validatedData = $request->validate($rules, $customMessages);


        $collaborator = Collaborator::where('curp', $request->input('curp'))->where('is_currently', 1 )->first();///valida que exista como empleado y este activo
        // dd($collaborator);
        if($collaborator){
            $user = User::where('collaborator_id', $collaborator->id)->where('state','1')->first(); /// verifica si ya tiene un user
            $mail = User::where('email', $request->input('email'))->where('state','1')->first(); /// verifica que el mail no este registrado
            if($user || $mail){
                return redirect()->route('registro.index')->with('error', 'Ya cuenta con un usuario.');    
            }else{
                $confirmation_code =  Str::random(10);
                $user =  User::create([
                    'collaborator_id' => $collaborator->id,
                    'email' => $request->input('email'),
                    'email_verified_at' => $request->input('email'),
                    'confirmation_code' => $confirmation_code,
                    'password' => bcrypt($request->input('password'))
                ]);
                
                $user->assignRole('Colaborador');
                
                Mail::to($user->email)->send(new MyTestMail($user));
                // Mail::to('tov.anahi@gmail.com')->send(new MyTestMail($user));

                return redirect()->route('registro.index')->with('titulo', '¡Gracias por Registrarse!')->with('mensaje', 'Por favor confirma tu correo.');
            } 
        }else{
            return redirect()->route('registro.index')->with('error', 'El registro no es posible.');    
        }
       
    }


    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (! $user)
            return redirect('/');

        $user->confirmed = true;
        $user->save();
        return redirect('/')->with('mensaje', 'Has confirmado correctamente tu correo!');
    }

    public function terminosCondiciones(){
        $pdf_name = "Términos y Condiciones.PDF";
        return PDF::loadView('pdfs.terminos_condiciones')->setPaper('letter', 'portrait')->stream($pdf_name);
    }
}
