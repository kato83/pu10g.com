<?php
namespace Drupal\img\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\node\Entity\Node;

class ImgController{
  public function createImage($node){
    // 画像のベース
    $filePath = realpath('./') . '/modules/custom/img/src/img/bg.png';
    $baseImage = imagecreatefrompng($filePath);

    $nodeId = $node->id();

    // 存在しないIDなら404を返す
    if(empty($node) || !$node->isPublished()) return;

    // 文字を描画
    $text = mb_convert_encoding($node->getTitle(), "UTF-8", "auto");
    $resultText = $this->mb_wordwrap($text, 32);

    $size = 40;
    $font = realpath('./') . '/modules/custom/img/src/font/mplus-1c-black.ttf';

    // 画像サイズを取得する
    $imageWidth  = imagesx($baseImage);
    $imageHeight = imagesy($baseImage);

    // 文字を画像の中央に寄せる
    $box = imagettfbbox($size, 0, $font, $resultText);
    $textWidth  = abs($box[2]) - abs($box[0]);
    $textHeight = abs($box[5]) - abs($box[3]);

    $x = ($imageWidth  - $textWidth ) / 2;
    $y = ($imageHeight + $textHeight) / 2;
    $color = imagecolorallocate($baseImage, 0, 0, 0);
    imagettftext($baseImage, $size, 0, $x, $y, $color, $font, $resultText);


    if(!file_exists(realpath('./') . '/sites/default/files/article/'))
    mkdir(realpath('./') . '/sites/default/files/article/', 777, true);
    imagejpeg($baseImage, realpath('./') . '/sites/default/files/article/' . $nodeId . '.jpg');
    imagewebp($baseImage, realpath('./') . '/sites/default/files/article/' . $nodeId . '.webp');

  }

  public function mb_wordwrap($str, $width=8, $break=PHP_EOL, $encode="UTF-8"){
    require_once 'TinySegmenterPHP.php';
    $t = new \TinySegmenter($str);
    $segment = $t->segment();
    $size = count($segment);

    $arr = [];
    $tmp = '';
    for($i = 0; $i < $size; $i++){
      $tmp .= $segment[$i];
      if(strlen($tmp . ($segment[$i + 1] ?? '')) > $width + 4){
        $arr[] = $tmp;
        $tmp = '';
      }else if($size === $i + 1){
        $arr[] = $tmp;
      }
    }

    return implode($break, $arr);
  }

  public function updateAll(){
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $ids = $query->execute();
    $node = Node::loadMultiple($ids);
    foreach ($node as $key => $value) {
      $this->createImage($value);
    }
  }
}
