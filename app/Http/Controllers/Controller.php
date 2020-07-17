<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // コンストラクタ
    public function __construct () {}

    protected function begin()
    {
    	DB::beginTransaction();
    }
    protected function commit()
    {
    	DB::commit();
    }
    protected function rollback()
    {
    	DB::rollback();
    }
}
