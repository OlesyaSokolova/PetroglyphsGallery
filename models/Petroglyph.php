<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Petroglyph extends ActiveRecord
{
    const SRC_IMAGE = 'http://localhost/petroglyphs/storage/';
    const VIEW_URL = 'petroglyphs/views/petroglyph/view.php';
    public $thumbnailImage;
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_table';
    }

  /*  public static function test() {
        //return self::find();
        $posts = Yii::$app->db->createCommand("SELECT id, text_value, image FROM test_table" )
            ->queryAll();
        return $posts;
    }*/

    /*public function getTestValues()
    {
        $query = $this->select(['id', 'text_value', 'image'] )
            ->from('test_table');
            //->where(['id' => '12']);
        /*$query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query;
        $rows = $query->all();
        return $rows;
    }*/

   /* public function getInfoById($id)
    {
        $query = $this->select(['id', 'text_value', 'image'] )
            ->from('test_table');
        /*$query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query;
        $rows = $query->all();
        return $rows;
    }*/

  /*  public static function getDb()
    {
        // использовать компонент приложения "db"
        return \Yii::$app->db;
    }*/

    /*public function uniqueValidator() {
        $authManager = Yii::$app->authManager;
        $value = $this->name;
        if ($authManager->getRole($value) !== null || $authManager->getPermission($value) !== null) {
            $message = Yii::t('yii', '{attribute} "{value}" has already been taken.');
            $params = [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $value,
            ];
            $this->addError('name', Yii::$app->getI18n()->format($message, $params, Yii::$app->language));
        }
    }*/

    /**
     * @inheritdoc
     */
    /*public function rules() {
        return [
            [['ruleName'], 'in',
                'range' => array_keys(Yii::$app->authManager->getRules()),
                'message' => Yii::t('rbac', 'Rule not exists')],
            [['name'], 'required'],
            [['name'], 'uniqueValidator', 'when' => function() {
                return $this->isNewRecord || ($this->item->name != $this->name);
            }],
            [['description', 'data', 'ruleName'], 'default'],
            [['name'], 'string', 'max' => 64]
        ];
    }*/

}