<?php
namespace App\Http\Interfaces;
interface WorkerTimeSheetRepositoryInterface
{
    public function history($request,$projects);

    public function updateDaily($request , $id);

    public function updateProductivity($request,$id);
}
