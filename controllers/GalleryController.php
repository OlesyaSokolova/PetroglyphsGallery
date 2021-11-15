<?php

namespace app\controllers;

use app\models\Petroglyph;
use yii\data\Pagination;
use yii\web\Controller;

class GalleryController extends Controller
{
    //const PAGE_LIMIT = 10;
    public function actionIndex()
    {
        $query = Petroglyph::find()
            ->orderBy(['id' => SORT_ASC]);
        $pages = new Pagination(['totalCount' => $query->count()]);
        //$pages = new Pagination(['totalCount' => 100]);

        $petroglyphs = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);
    }
}
