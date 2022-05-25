<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\City;
use App\Client;
use App\EmployeeImage;
use App\Http\Controllers\Controller;
use App\Installment;
use App\Outdoor;
use App\Project;
use App\Reservation;
use App\State;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
    public function saveProject(Request $request)
    {
//        return $request->all();

        $rules = [

            'name' => 'required',


        ];

        $this->validate($request, $rules);
        $row = Project::create($request->all());
//        $data = ClientRate::create($request->all());
        if ($row) {
            $data = [
                'status' => true,
                'data' => $row,

            ];
        } else {
            $data = [
                'status' => false,


            ];
        }


        return response()->json($data, 200);
    }

    public function deleteEmployeeImage(Request $request)
    {
//		return $id;
//		return response()->json( "true", 200 );
        $row = EmployeeImage::findOrFail($request->image_id);
        if ($row) {
            $this->deleteImage($row->image);
            $this->deleteImage($row->image_thumb);

            $row->delete();
        }

        return response()->json("true", 200);
    }

    public function deleteImage($name)
    {
        $deletepath = base_path($name);
        if (file_exists($deletepath) and $name != '') {
            unlink($deletepath);
        }

        return true;
    }

    public function states(Request $request)
    {
        $rows = State::where('country_id', $request->id)->select('name', 'id')
//            ->orderBy('arrangement','ASC')
            ->orderByRaw('name')
            ->get();

        if ($rows->count() > 0) {
            $rows = $this->formatOptions($rows, trans('main.select_state'));
            return response()->json([
                'status' => true,
                'data' => $rows
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'no data'
        ], 200);
    }

    public function cities(Request $request)
    {


        $rows = City::where('state_id', $request->id)->select('name', 'id')
//            ->orderBy('arrangement','ASC')
            ->orderByRaw('name')
            ->get();

        if ($rows->count() > 0) {
            $rows = $this->formatOptions($rows, trans('main.select_city'));
            return response()->json([
                'status' => true,
                'data' => $rows
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'no data'
        ], 200);
    }
    public function subCats(Request $request)
    {


        $rows = Category::where('main_category', $request->id)->select('name', 'id')
//            ->orderBy('arrangement','ASC')
            ->orderByRaw('name')
            ->get();

        if ($rows->count() > 0) {
            $rows = $this->formatOptions($rows, trans('main.select_category'));
            return response()->json([
                'status' => true,
                'data' => $rows
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'no data'
        ], 200);
    }

    private function formatOptions($values, $label)
    {
        $option = '<option value="">' . $label . '</option>';
        foreach ($values as $value) {
            $option .= "<option value='{$value->id}'>{$value->name}</option>";
        }
        return $option;
    }


}
