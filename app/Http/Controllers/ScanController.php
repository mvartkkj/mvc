<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string|max:50'
        ]);

        // Salva o código da mesa na sessão
        session(['table_code' => $request->table_code]);

        return redirect()->route('menu')
            ->with('success', 'Mesa registrada com sucesso!');
    }
}