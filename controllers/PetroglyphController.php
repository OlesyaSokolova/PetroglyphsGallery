<?php

namespace app\controllers;

use app\models\Petroglyph;
use yii\web\Controller;
use yii\web\HttpException;

class PetroglyphController extends Controller
{
    public function actionView($id)
    {
        $petroglyph = Petroglyph::findOne($id);
        if (empty($petroglyph)) {
            throw new HttpException(404);
        }

        return $this->render('view', [
            'petroglyph' => $petroglyph,
            /*'categoryId' => $categoryId,
            'objectPrev' => $objectPrev,
            'objectNext' => $objectNext,*/
        ]);
    }
}