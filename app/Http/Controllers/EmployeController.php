<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index()
    {
        $employes = Employe::all();
        return view('employes.index', compact('employes'));
    }

    public function create()
    {
        return view('employes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'matricule' => 'required|string|unique:employes',
            'contact' => 'required|string|max:20',
        ]);

        Employe::create($request->all());

        return redirect()->route('employes.index')->with('success', 'Employé ajouté avec succès.');
    }

    public function edit(Employe $employe)
    {
        return view('employes.edit', compact('employe'));
    }

    public function update(Request $request, Employe $employe)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'matricule' => 'required|string|unique:employes,matricule,' . $employe->id,
            'contact' => 'required|string|max:20',
        ]);

        $employe->update($request->all());

        return redirect()->route('employes.index')->with('success', 'Employé modifié avec succès.');
    }

    public function destroy(Employe $employe)
    {
        $employe->delete();
        return redirect()->route('employes.index')->with('success', 'Employé supprimé.');
    }
}
