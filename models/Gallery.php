<?php

namespace app\models;

use common\models\Petroglyph;
use yii\db\ActiveQuery;
use yii\db\Query;


//class Gallery extends ActiveQuery
class Gallery extends Query
{
    const SRC_IMAGE = '/storage/';

    public function getTestValues()
    {
        $query = $this->select(['id', 'text_value', 'image'] )
            ->from('test_table')
            ->where(['id' => '12']);
        /*$query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query;*/
        $rows = $query->all();
        return $rows;
    }
}