<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class ApprovalController extends Controller
{
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.approvals.index', compact('users'));
    }

    public function accepter(User $user)
{
    $user->is_approved = true;  // ← assignation explicite
    $user->save();              // ← puis sauvegarde

    return back()->with('success', 'Utilisateur approuvé avec succès.');
}


    public function refuser(User $user)
    {
        $user->delete(); // ou autre logique
        return back()->with('success', 'Utilisateur refusé et supprimé.');
    }
}
