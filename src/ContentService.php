<?php
namespace Sheld\Contentbox;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentService{
    public function __construct()
    {
        $this->extraCache();
    }


    /**
     * @name save 保存文章
     * @param string $title 标题
     * @param integer $belongto 所属栏目
     * @param string $contentHtml 包含html的文章正文
     * @param array $formExtras 从form表单提交过来的键值对，键请以ex_开头
     * @return
     */
    public function save($title,$belongto,$contentHtml,$formExtras)
    {
        $extras=[];
        $extraDefines=Cache::store('file')->get('extraDefine');
        foreach($formExtras as $formKey=>$formValue)
        {
            $extra_define=$extraDefines['ex_'.$formKey];
            $extra=new Extra();
            $extra->id=$extra_define->id;
            $extra->name=$extra_define->name;
            $extra->varkey=$extra_define->varkey;
            $extra->extras=$extra_define->extras;
            $extra->value=$formValue;
            $extras[]=$extra;
        }

        $content=new Contentbox();
        $content->title=$title;
        $content->belongto=$belongto;
        $content->contentHtml=$contentHtml;
        $content->extras=json_encode($extras);
        $content->save();

    }

    /**
     * @name read 读取单篇文章
     * @param integer $contentID 文章ID
     * @return Contentbox 文章对象
     */
    public function read($contentID){
        $content=Contentbox::findOrFail($contentID);
        return $content;
    }

    /**
     * @name changeStatus 改变文章状态
     * @param integer $contentID 文章ID
     * @param integer $status 新状态
     * @return
     */
    public function changeStatus($contentID,$status){
        $content=Contentbox::findOrFail($contentID);
        $content->status=$status;
        $content->save();
    }

    /**
     * @name listByBelongto 文章列表
     * @param integer $belongto 所属栏目
     * @param integer $nums 每次返回结果集数目
     * @param integer $page 当前页数
     * @param collection $contents 文章集合
     * @return
     */
    public function listByBelongto($belongto,$nums=10,$page=1){
        $contents=Contentbox::where('belongto', $belongto)->offset(($page-1)*$nums)->limit($nums)->get();
        return $contents;
    }


    /**
     * @name extraNew 新建附加属性
     * @param string $type 属性定义组
     * @param string $name 属性提示标题
     * @param string $varkey 属性标识符
     * @param integer $mustinput 是否必填，默认为0
     * @param string $default 默认值
     * @param string $validations 验证要求
     * @param string (json) extras 其他自定义内容
     * @return
     */
    public function extraNew($type,$name,$varkey,$mustinput=0,$default='',$validations='',$extras='{}')
    {
        $isExist=Extra::where('varkey',$varkey)->first();
        if(!$isExist){
            $extra=new Extra();
            $extra->type=$type;
            $extra->name=$name;
            $extra->varkey=$varkey;
            $extra->mustinput=$mustinput;
            $extra->default=$default;
            $extra->validations=$validations;
            $extra->extras=$extras;
            $extra->save();
        }
    }

    /**
     * @name extraUpdate 更新附加属性
     * @param string $type 属性定义组
     * @param string $name 属性提示标题
     * @param integer $mustinput 是否必填，默认为0
     * @param string $default 默认值
     * @param string $validations 验证要求
     * @param string (json) extras 其他自定义内容
     * @return
     */
    public function extraUpdate($type,$name,$mustinput=0,$default='',$validations='',$extras='{}')
    {
        $extra=Extra::where('varkey',$varkey)->first();
        if($extra){
            $extra->type=$type;
            $extra->name=$name;
            $extra->mustinput=$mustinput;
            $extra->default=$default;
            $extra->validations=$validations;
            $extra->extras=$extras;
            $extra->save();
        }
    }
















    private function extraRecache()
    {
        Cache::forget('extraDefine');
        $this->extraCache();
    }
    private function extraCache()
    {
        if (!Cache::has('extraDefine')) {
            $extraDefines=Extra::all();

            $extraArr=[];
            foreach($extraDefines as $extraDefine)
            {
                $extraArr[$extraDefine->key]=$extraDefine;
            }
            Cache::store('file')->put('extraDefine', $extraArr, 60000);
        }
    }
}
