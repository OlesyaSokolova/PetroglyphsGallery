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
    public $css = [
    'css/loader.object.css',
    'css/jquery.fancybox.min.css',
    'css/colorpicker.css',
    ];
public $js = [
    'js/three/dat.gui.min.js',
    'js/three/three.min.js',
    'js/three/OrbitControls.js',
    'js/three/OBJLoader.js',
    'js/three/MTLLoader.js',
    'js/three/GLTFLoader.js',
    'js/three/DRACOLoader.js',
    'js/three/TrackballControls.js',
    'js/three/postprocessing/EffectComposer.js',
    'js/three/postprocessing/ShaderPass.js',
    'js/three/shaders/CopyShader.js',
    'js/three/postprocessing/RenderPass.js',
    'js/jquery.fancybox.min.js',
    'js/colorpicker.min.js',
    'js/viewer.js',
    'js/label.js',
    'js/loader.object.js',
    ];
public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
    ];
}
