<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;
use App\ip;

class DownloadTxt extends AbstractAction
{
    public function getTitle()
    {
        return 'Download Text File';
    }

    public function getIcon()
    {
        return 'voyager-down-circled';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        // return route('my.route');
    }

    public function massAction($ids, $comingFrom)
    {
        $txt = [];
        $data = ip::select('ip')->get();
        foreach ($data as $key => $val) {
            $txt[$key] = $val['ip'] . ', ';
        }
        $data = $txt;

        $file = 'ip_file.txt';
        $destinationPath = public_path() . "/upload/";
        if (!is_dir($destinationPath)) {mkdir($destinationPath, 0777, true);}
        \File::put($destinationPath . $file, $data);
        return response()->download($destinationPath . $file);
        return redirect($comingFrom);
    }
}
