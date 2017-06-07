<?php
namespace backend\libraries;


use common\models\Category;
use yii\helpers\Html;

class CategoryLib
{
    public static function getCategoryName($category_id)
    {
        $category = Category::findOne($category_id);
        if(isset($category->name) && !empty($category->name)){
            $category_name = $category->name;
        }else{
            $category_name = '';
        }
        return $category_name;
    }


    public static function getCategoryData($category_id)
    {
        $category_data=[];
        $category = Category::findOne($category_id);
        $category_data[$category_id]=$category->name;
        return $category_data;

    }


    public static function getParentCategories()
    {
        $categories = Category::find()->where(['deep'=>2,'status'=>1])->asArray()->all();
        return $categories;
    }
    /*
     * 根据父分类ID获取子分类
     */
    public static function getChildCategories($category_id)
    {
        $categories = Category::find()->where(['parent_id'=>$category_id,'status'=>1,'deep'=>3])->asArray()->all();
        return $categories;
    }
    public static function getChildCategoryHtml ($category_id)
    {
        $categorys = Category::find()
            ->where('parent_id=:pid',[':pid'=>$category_id])
            ->andWhere(['=', 'deep', 3])
            ->asArray()
            ->all();
        $child_category_html = '<div class="division">
                                <h4>商品子分类</h4>
                                <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>分类ID</th>
                                            <th>分类名称</th>
                                            <th>分类图片</th>
                                            <th>排序</th>
                                            <th>分类级别</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead><tbody>';
        foreach ($categorys as $category){
            $child_category_html .= '<tr data-key="'.$category['id'].'">';
            $child_category_html .= '<td>'.$category['id'].'</td>';
            $child_category_html .= '<td>'.$category['name'].'</td>';
            $child_category_html .= '<td>'. Html::img($category['ico_path'],['width' => '20px','height'=>'20px']).'</td>';
            $child_category_html .= '<td>'.$category['order_no'].'</td>';
            $child_category_html .= '<td>'.$category['deep'].'</td>';
            $child_category_html .= '<td>'.
                Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                    'data-toggle' => 'modal',
                    'data-target' => '#update-child-category-modal',
                    'class' => 'data-update-child-category',
                ]).'</td>';
            $child_category_html .= '</tr>';
            ;
        }
        $child_category_html .= '</tbody></table>
                            </div>';
        return $child_category_html;
    }


}