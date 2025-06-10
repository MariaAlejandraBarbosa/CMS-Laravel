<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome(){
        return view('admin.settings.settings');
    }

    public function postHome(Request $request){
        $app_project_path = 'c:/www/task/config';
        if(!file_exists(config_path().'/cms.php')):
            fopen(config_path().'/cms.php', 'w');
        endif;

        $file = fopen(config_path().'/cms.php', 'w');
        fwrite($file, '<?php'.PHP_EOL);
        fwrite($file, 'return ['.PHP_EOL);
        foreach($request->except(['_token']) as $key => $value):
            if(is_null($value)):
                $value = 'null';
            endif;
            fwrite($file, '\''.$key.'\' => \''.$value.'\','. PHP_EOL);
        endforeach;
        fwrite($file, ']'.PHP_EOL);
        fwrite($file, '?>'.PHP_EOL);
        fclose($file);

        copy(config_path().'/cms.php', $app_project_path.'/cms.php');

        return back()->with('message','Las configuraciones fueron guardadas con éxito.')->with('typealert','success');
    }
}
