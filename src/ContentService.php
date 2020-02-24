<?php
namespace Sheld\Contentbox;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentService{
    public function __construct()
    {
        if (!Cache::has('key')) {
            $extraDefines=DB::select('select * from extras');

            $extraArr=[];
            foreach($extraDefines as $extraDefine)
            {
                $extraArr[$extraDefine->key]=$extraDefine;
            }
            Cache::store('file')->put('extraDefine', $extraArr, 60000);
        }
    }
    public function build($title,$belongto,$contentHtml,$formExtras)
    {
        $extras=[];
        $extraDefines=Cache::store('file')->get('extraDefine');
        foreach($formExtras as $formKey=>$formValue)
        {
            $extra_define=$extraDefines[$formKey];
            $extra=new Extra($extra_define->id,$extra_define->name,$extra_define->key,$extra_define->extras,$formValue);
            $extras[]=$extra;
        }
        $content=new Content($title,$belongto,$contentHtml,$extras);
        $content->persistence();
    }

    public function exbuild($contentID){
        $content=new Content($contentID);
        $content->extras=json_decode($content->extras);
        return $content;
    }
}
