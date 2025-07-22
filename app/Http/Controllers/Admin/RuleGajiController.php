<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuleGaji;
use Illuminate\Http\Request;

class RuleGajiController extends Controller
{
    public function index()
    {
        $menu = 'rulegaji';
        $rulegaji = RuleGaji::all();
        return view('pages.admin.rulegaji.index', compact('menu', 'rulegaji'));
    }

    public function create()
    {
        $menu = 'rulegaji';
        return view('pages.admin.rulegaji.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        RuleGaji::create($data);
        return redirect()->route('admin.rule-gaji.index')->with('success', 'Rule Gaji berhasil ditambahkan');
    }

    public function show(RuleGaji $rule_gaji)
    {
        $menu = 'rulegaji';
        return view('pages.admin.rulegaji.show', compact('rule_gaji', 'menu'));
    }

    public function edit(RuleGaji $rule_gaji)
    {
        $menu = 'rulegaji';
        return view('pages.admin.rulegaji.edit', compact('rule_gaji', 'menu'));
    }

    public function update(Request $request, RuleGaji $rule_gaji)
    {
        $rule_gaji->update($request->all());
        return redirect()->route('admin.rule-gaji.index')->with('success', 'Rule Gaji berhasil diubah');
    }

    public function destroy(RuleGaji $rule_gaji)
    {
        $rule_gaji->delete();
        return redirect()->route('admin.rule-gaji.index')->with('success', 'Rule Gaji berhasil dihapus');
    }
}
