<?php

namespace App\Http\Controllers;

class PracticeController extends Controller
{
  public function sample()
  {
    return view('practice');
  }

  public function sample2()
  {
    $test = 'practice2';
    return view('practice2', ['testparam' => $test]);
  }
  public function sample3()
  {
    $testParam = 'test';
    return view('practice3', ['testparam' => $test]);
  }
}
