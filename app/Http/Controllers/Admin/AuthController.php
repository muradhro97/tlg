<?php

namespace App\Http\Controllers\Admin;

use App\Backup;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
//        dd(456);
        if (!auth()->check()) {
//            dd(567);
            return view('admin.layouts.login');
        } else {

            return redirect('/admin');
        }
    }

    public function login(Request $request)
    {
//        $settings = Setting::findOrNew(1);
//        $last_backup = $settings->last_backup;
////        return now()->addDay()->format('Y-m-d  H:i:s');
//        if (now()->subDay()->gte($last_backup)) {
//            return "yes";
//        } else {
//            return "no";
//        }

        $this->validate($request, [
            'user_name' => 'required',
            'password' => 'required|min:3'
        ]);
        $user = User::where('user_name', $request->user_name)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                auth()->login($user);
                activity()
                    ->causedBy($user)
                    ->performedOn($user)
                    ->log($user->name . ' login ');

                $backup_check = Backup::latest()->first();
                if ($backup_check) {
                    $last_backup = $backup_check->date;
                } else {
                    $last_backup = null;
                }

                if (now()->subDay()->gte($last_backup) or is_null($last_backup)) {
//                if (true) {


                    $backup = $this->backup();
                    $row = new Backup();
                    if ($backup) {

                        $row->name = $backup;
                        $row->date = now();
                        $row->fail_date = null;
                    } else {
                        $row->name = null;
                        $row->date = null;
                        $row->fail_date = now();


                    }
                    $row->save();
                    $backup_to_delete = Backup::latest()->skip(10)
                        ->take(PHP_INT_MAX)
                        ->get();
                    if ($backup_to_delete->count() > 0) {
                        foreach ($backup_to_delete as $del) {
                            $this->deleteFile($del->name);

                            $del->delete();
                        }
//                    $backup_to_delete->delete();
                    }
                }

                return redirect()->intended('admin');

//                return redirect('admin');
            } else {
                #wrong pass
                toastr()->error(trans('main.wrong_password'));
                return redirect()->back()->withInput($request->only('email'));
            }
        } else {
            #no user found
            toastr()->error(trans('main.wrong_user_name'));
            return redirect()->back()->withInput($request->only('email'));
        }

        // Attempt to log the user in
//        if ( auth()->attempt( [ 'user_name' => $request->user_name, 'password' => $request->password ] ) ) {
////        return $request->all();
//            // if successful, then redirect to their intended location
//
//            return redirect('admin');
//        }
//
//        // if unsuccessful, then redirect back to the login with the form data
//        toastr()->error( trans( 'admin.wrong_data' ) );
//        return redirect()->back()->withInput( $request->only( 'email', 'remember' ) );
    }

    public function logout()
    {
        $user = auth()->user();
        auth()->logout();

        activity()
            ->causedBy($user)
//            ->performedOn(  $user)
            ->log($user->name . ' logout  ');
        return redirect('/');
    }

    public function backup()
    {
        try {


            //ENTER THE RELEVANT INFO BELOW
            $mysqlHostName = env('DB_HOST');
            $mysqlUserName = env('DB_USERNAME');
            $mysqlPassword = env('DB_PASSWORD');
            $DbName = env('DB_DATABASE');
//        $backup_name        = "mybackup.sql";
//        $tables             = array("users","messages","posts"); //here your tables...

            $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $get_all_table_query = "SHOW TABLES";
            $result = DB::select(DB::raw($get_all_table_query));

            $prep = "Tables_in_$DbName";
            foreach ($result as $res) {
                $tables[] = $res->$prep;
            }
//        $statement = $connect->prepare($get_all_table_query);
//        $statement->execute();
//      return  $tables = $statement->fetchAll();

//return$tables;
            $output = '';
            foreach ($tables as $table) {
                $show_table_query = "SHOW CREATE TABLE " . $table . "";
                $statement = $connect->prepare($show_table_query);
                $statement->execute();
                $show_table_result = $statement->fetchAll();

                foreach ($show_table_result as $show_table_row) {
                    $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
                }
                $select_query = "SELECT * FROM " . $table . "";
                $statement = $connect->prepare($select_query);
                $statement->execute();
                $total_row = $statement->rowCount();

                for ($count = 0; $count < $total_row; $count++) {
                    $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                    $table_column_array = array_keys($single_result);
                    $table_value_array = array_values($single_result);
                    $output .= "\nINSERT INTO $table (";
                    $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                    $output .= "'" . implode("','", $table_value_array) . "');\n";
                }
            }
//        return $output;
//        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
            $file_name = 'database_backup/database_backup_on_' . date('y_m_d') . '_' . time() . '' . rand(11111, 99999) . '.' . '.sql';
            $file_handle = fopen($file_name, 'w+');
            fwrite($file_handle, $output);
            fclose($file_handle);
//        header('Content-Description: File Transfer');
//        header('Content-Type: application/octet-stream');
//        header('Content-Disposition: attachment; filename=' . basename($file_name));
//        header('Content-Transfer-Encoding: binary');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate');
//        header('Pragma: public');
//        header('Content-Length: ' . filesize($file_name));
            ob_clean();
//            flush();
//        readfile($file_name);
//        unlink($file_name);
            return $file_name;
        } catch (\Illuminate\Database\QueryException $ex) {

            return false;
            $response = [
                "status" => false,
//                "key" => "error",
                "message" => $ex->errorInfo[2]
            ];
            return response()->json($response, 422);
        } catch (\Exception $e) {
            return false;
            return [
                "status" => false,
//                "key" => "error",
                "message" => $e->getMessage(),
            ];
        }

    }

    public static function deleteFile($name)
    {
        $deletepath = base_path($name);
        if (file_exists($deletepath) and $name != '') {
            unlink($deletepath);

        }

        return true;
    }

}
