<?php

namespace App\Http\Controllers\CharacterCheck;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CharacterCheckControler extends Controller
{
    public function index()
    {
        return view('character_check.index');
    }
}
