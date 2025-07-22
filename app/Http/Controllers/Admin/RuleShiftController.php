<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuleShift;
use Illuminate\Http\Request;

class RuleShiftController extends Controller
{
    public function index()
    {
        $menu = 'ruleshift';
        $ruleshift = RuleShift::all();
        return view('pages.admin.ruleshift.index', compact('menu', 'ruleshift'));
    }

    public function create()
    {
        $menu = 'ruleshift';
        return view('pages.admin.ruleshift.create', compact('menu'));
    }

    public function store(Request $request)
    {
        RuleShift::create($request->all());
        return redirect()->route('admin.ruleshift.index')->with('success', 'Rule Shift berhasil ditambahkan');
    }

    public function show(RuleShift $ruleshift)
    {
        $menu = 'ruleshift';
        return view('pages.admin.ruleshift.show', compact('ruleshift', 'menu'));
    }

    public function edit(RuleShift $ruleshift)
    {
        $menu = 'ruleshift';
        return view('pages.admin.ruleshift.edit', compact('ruleshift', 'menu'));
    }

    public function update(Request $request, RuleShift $ruleshift)
    {
        $ruleshift->update($request->all());
        return redirect()->route('admin.ruleshift.index')->with('success', 'Rule Shift berhasil diubah');
    }

    public function destroy(RuleShift $ruleshift)
    {
        $ruleshift->delete();
        return redirect()->route('admin.ruleshift.index')->with('success', 'Rule Shift berhasil dihapus');
    }
}
