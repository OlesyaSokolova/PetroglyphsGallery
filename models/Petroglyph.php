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
}
