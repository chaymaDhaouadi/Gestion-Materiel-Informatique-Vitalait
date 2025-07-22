<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.approval.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'Utilisateur approuvé avec succès.');
    }
}
