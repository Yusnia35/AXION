<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RuleController extends Controller
{
    /**
     * Display expert system knowledge base rules.
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $rules = Rule::with(['ruleKondisis', 'tindakanRules'])->get();

        return view('rules.index', compact('rules', 'currentWorkspace', 'currentUser'));
    }
}
