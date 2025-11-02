<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cargo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function handleGoogleCallback()
    {
        try {
            // Pegar os dados do usuário do Google
            $googleUser = Socialite::driver('google')->user();
            
            // Verificar se o usuário já existe pelo e-mail
            $cliente = Cliente::where('e_mail', $googleUser->email)->first();
            
            if (!$cliente) {
                // Se não existe, criar novo cliente
                $cliente = Cliente::create([
                    'nome' => $googleUser->name,
                    'e_mail' => $googleUser->email,
                    'passwd' => Str::random(16), // Senha aleatória (não será usada)
                    'cargo_id' => 1, // Cliente padrão
                ]);
            }
            
            // Fazer login na sessão
            session([
                'user_id' => $cliente->cod_cliente,
                'user_name' => $cliente->nome,
                'user_email' => $cliente->e_mail,
                'user_cargo' => $cliente->cargo_id,
            ]);
            
            return redirect()->route('menu')
                ->with('success', 'Login com Google realizado com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erro ao fazer login com Google: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        // Validar os dados de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,e_mail',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'email.unique' => 'Este e-mail já está cadastrado',
            'phone.required' => 'O telefone é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não conferem',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Criar um novo cliente
            $cliente = Cliente::create([
                'nome' => $request->name,
                'e_mail' => $request->email,
                'celular' => $request->phone,
                'passwd' => $request->password, // Hash automático no model
                'cargo_id' => 1, // 1 = Cliente padrão
            ]);

            // Redirecionar para login
            return redirect()->route('login')
                ->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar cadastro: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'password.required' => 'A senha é obrigatória',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buscar o cliente pelo e-mail
        $cliente = Cliente::where('e_mail', $request->email)->first();

        // Verificar se existe e se a senha está correta
        if ($cliente && Hash::check($request->password, $cliente->passwd)) {
            // Login bem-sucedido
            session([
                'user_id' => $cliente->cod_cliente,
                'user_name' => $cliente->nome,
                'user_email' => $cliente->e_mail,
                'user_cargo' => $cliente->cargo_id,
            ]);

            return redirect()->route('menu')
                ->with('success', 'Bem-vindo, ' . $cliente->nome . '!');
        }

        return redirect()->back()
            ->with('error', 'E-mail ou senha incorretos!')
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home')
            ->with('success', 'Você saiu com sucesso!');
    }
}