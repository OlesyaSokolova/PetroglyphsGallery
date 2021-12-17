<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
* Class View3dAsset
*
* @package app\assets
*/
class ViewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /*public $css = [
    'css/loader.object.css',
    'css/jquery.fancybox.min.css',
    'css/colorpicker.css',
    ];*/
public $js = [
    'js/viewer.js',
    //'js/label.js',
    'js/petroglyph.loader.js',
    ];
public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
    ];
}
