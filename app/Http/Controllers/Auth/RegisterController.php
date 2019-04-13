<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = 'users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $roles = isset($data['roles']) ? $data['roles'] : 'user';
        $birthday = isset($data['birthday']) ? $data['birthday'] : null;
        $password =  isset($data['roles']) ? '*' : Hash::make('mojehaslo');
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'roles' => $roles,
            'birthday' => $birthday,
            'password' => $password,
        ]);
    }

    public function showRegistrationForm()
    {
        if(Auth::user()->canTakeName()) {
            return redirect()->route('users')->with('danger', 'Możesz dodać uczestnika tylko wtedy, gdy losowanie jest zresetowane');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

 //       $this->guard()->login($user);
        foreach (User::all() as $user) {
            if(\Globals::getDateToDiff($user->birthday) > date('Y-m-d')) {
                $user->daysToBirthday = date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
            } elseif($user->birthday == null) {
                $user->daysToBirthday = 444;
            }else {
                $user->daysToBirthday = 365 - date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
            }
            $user->save();
        }
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('success', 'Pomyślnie dodano uczestnika');
    }

    public function showRegisterChildren()
    {
        return view('auth.registerChildren');
    }

    public function registerChildren(Request $request)
    {
        $this->redirectTo = 'admin/children';
        $int = User::orderBy('id', 'desc')->first()->id + 1;
        $request->request->add([
            'email' => 'children'.$int.'@children.com',
            'roles' => 'child'
        ]);
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //       $this->guard()->login($user);
        foreach (User::all() as $user) {
            if(\Globals::getDateToDiff($user->birthday) > date('Y-m-d')) {
                $user->daysToBirthday = date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
            } elseif($user->birthday == null) {
                $user->daysToBirthday = 444;
            }else {
                $user->daysToBirthday = 365 - date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
            }
            $user->save();
        }
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('success', 'Pomyślnie dodano dzieciaka');
    }
}
