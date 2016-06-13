<?php

namespace App\Http\Controllers;

use App\EDI850;
use Illuminate\Http\Request;

use App\Http\Requests;

class EDIGeneratorController extends Controller
{
    /*
     * This method is using class member access on instantiation and
     * will break if the version of PHP is below 5.4
     */
    public function EDI850Generator()
    {
//        Lastly, I used the symbol ~ to separate EDI segments as it is the most common example online
        return view('pages.expo')->with([
            'ediDoc' =>  (new EDI850)->createEDI850(generateTestOrderArray())
        ]);
    }
}
