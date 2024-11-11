<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControllers extends Controller
{
    //
    public function index()
    {
        // hacer relacion con otra tabla
        $tasks = Task::with('User')->get();


        // traer los task de los usuarios
        // $user = Auth::user();
        // $tasks = $user->tasks;


        return view('dashboard', compact('tasks'));
    }
}
