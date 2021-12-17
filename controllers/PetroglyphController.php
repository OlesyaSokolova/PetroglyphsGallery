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

    public function actionEdit($id)
    {
        $petroglyph = Petroglyph::findOne($id);
        if (empty($petroglyph)) {
            throw new HttpException(404);
        }

        return $this->render('edit', [
            'petroglyph' => $petroglyph,
            /*'categoryId' => $categoryId,
            'objectPrev' => $objectPrev,
            'objectNext' => $objectNext,*/
        ]);
    }

    public function actionDelete($id)
    {
        $petroglyph = Petroglyph::findOne($id);
        $petroglyph->delete();
    }

    public function actionSave()
    {
        $data = (!empty($_POST['params'])) ? json_decode($_POST['params'], true) : "empty params";
        $id = $data["id"];
        $newName = $data["newName"];
        $newDescription = $data["newDescription"];
        $newSettings = json_encode($data["newSettings"]);

        $petroglyph = Petroglyph::findOne($id);
        $petroglyph->name = $newName;
        $petroglyph->description = $newDescription;
        $petroglyph->settings = $newSettings;
        $petroglyph->update();
    }
}
