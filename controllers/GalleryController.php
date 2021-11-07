<?php

namespace app\controllers;

use app\models\Petroglyph;
use yii\data\Pagination;
use yii\web\Controller;

class GalleryController extends Controller
{
    public function actionIndex()
    {
        $gallery = new Petroglyph();
        $petroglyphs = $gallery->getTestValues();
        //$pages = new Pagination(['totalCount' => 76]);
        $pages = new Pagination(['totalCount' => sizeof($petroglyphs)]);
        return $this->render('index',[
            'petroglyphs' => $petroglyphs,
            'pages' => $pages,
        ]);

    }
}