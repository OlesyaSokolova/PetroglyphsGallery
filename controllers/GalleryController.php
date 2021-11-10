<?php

namespace app\controllers;

use app\models\Customer;
use app\models\Petroglyph;
use yii\data\Pagination;
use yii\web\Controller;

class GalleryController extends Controller
{
    const PAGE_LIMIT = 10;
    public function actionIndex()
    {
        //$query = Petroglyph::test();
        $query = Petroglyph::find();
            //->orderBy(['id' => SORT_DESC]);
        //$pages = new Pagination(['totalCount' => 76]);
        //$pages = new Pagination(['totalCount' => sizeof($query)]);
        $pages = new Pagination(['totalCount' => $query->count()]);

        $petroglyphs = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);

    }
}