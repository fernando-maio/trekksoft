<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Commands;
use App\Components\Validations;

class CommandController extends Controller
{
    /**
     * component
     *
     * @var Component
     */
    private $component;
    
    public function __construct(Commands $component)
    {
        $this->component = $component;
    }

    public function send(Request $request)
    {
        $validation = Validations::checkCommand($request->commands);        
        if (!$validation['status']) {
            return redirect()
                ->back()
                ->withErrors($validation['msg']);
        }

        $commands = $this->component->send($request->commands);        
        if(!$commands['status'])
            return redirect()
                ->back()
                ->withErrors($commands['msg']);

        return view('welcome', array('position' => $commands['msg']));
    }
}
