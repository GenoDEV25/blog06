<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController {
    public function login(){
        
        if (session()->get('isLoggedIn')) return redirect()->to('/admin/posts');
        return view('admin/login');
    }

    public function attemptLogin(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = (new UserModel())->where('email',$email)->first();
        if (!$user || !password_verify($password, $user['password'])){
            return redirect()->back()->with('error','Credenciales inválidas')->withInput();
        }

        session()->set('isLoggedIn', true);
        session()->set('user', ['id'=>$user['id'],'email'=>$user['email'],'name'=>$user['name']]);
        return redirect()->to('/admin/posts');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
