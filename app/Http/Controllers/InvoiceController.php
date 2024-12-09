<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    //afficher la liste des factures
    public function index(){
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }
    ///afficher le formulaire de création d'une facture
    public function create(){
        return view('invoices.create');
    }
    ///enregistrer une nouvelle facture
    public function store(Request $request){
        $validated=$request->validate([
            'invoice_date' => 'required|date',
            'client_name' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,canceled',
        ]);
        Invoice::create($validated);
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }
    //afficher le formulaire d'édition d'une facture
    public function edit($id){
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }
    //mettre à jour une facture
    public function update(Request $request, $id){
        $invoice = Invoice::findOrFail($id);
        $validated = $request->validate([
            'invoice_date' => 'required|date',
            'client_name' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,canceled',
        ]);
        $invoice->update($validated);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }
    //supprimer une facture
    public function destroy($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }


}
