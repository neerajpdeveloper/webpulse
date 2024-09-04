<?php
// app/Helpers/Image_helper.php
if (! function_exists('Image_thumb')) {
    function Image_thumb($thumb = array(), $perform = 'R') {
        $config = [
            'image_library' => 'gd2',
            'create_thumb' => true,
            'thumb_marker' => false,
            'source_image' => $thumb['source_path'] . $thumb['org_image'],
            'width' => $thumb['width'],
            'height' => $thumb['height']
        ];

        if (array_key_exists('destination_path', $thumb)) {
            $thum_img_name = $thumb['org_image'];
            $config['new_image'] = $thumb['destination_path'] . "/" . $thum_img_name;
        } else {
            $thum_img_name = "thumb_" . $thumb['width'] . "_" . $thumb['height'] . "_" . $thumb['org_image'];
            $thumb['destination_path'] = IMG_CACH_DIR;
            $config['new_image'] = IMG_CACH_DIR . "/" . $thum_img_name;
        }

        $image_lib = \Config\Services::image();
        $image_lib->initialize($config);

        if (! file_exists($thumb['destination_path'] . "/" . $thum_img_name)) {
            if ($perform == 'C') {
                list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);
                $ratio = $original_width / $original_height;
                $thumbRatio = $thumb['width'] / $thumb['height'];
                if ($ratio < $thumbRatio) {
                    $srcHeight = round($original_height * $ratio / $thumbRatio);
                    $config['y_axis'] = round(($original_height - $srcHeight) / 2);
                } else {
                    $srcWidth = round($original_width * $thumbRatio / $ratio);
                    $config['x_axis'] = round(($original_width - $srcWidth) / 2);
                }

                $config['maintain_ratio'] = false;
                $image_lib->initialize($config);
                $image_lib->crop();
            }

            if ($perform == 'AR') {
                $config['ar_width'] = $thumb['width'];
                $config['ar_height'] = $thumb['height'];
                $config['maintain_ratio'] = false;
                $config['master_dim'] = "height";
                if ($thumb['width'] > $thumb['height']) {
                    $config['master_dim'] = "width";
                }
                $image_lib->initialize($config);
                $image_lib->resize();
            }

            if ($perform == 'R') {
                list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);
                $config['width'] = ( $thumb['width'] >= $original_width ) ? $original_width : $thumb['width'];
                $config['height'] = ( $thumb['height'] >= $original_height ) ? $original_height : $thumb['height'];
                $config['maintain_ratio'] = true;
                $image_lib->initialize($config);
                $image_lib->resize();
            }
        }

        return $image_lib->display_errors();
    }
}

// if (! function_exists('createImageFromName')) {
// function createImageFromName($name) {
//     $width = 200;
//     $height = 200;
//     $fontSize = 72;
//     $fontFile = 'public/sitepanel/assets/img/ShortBaby-Mg2w.ttf'; // Replace with path to font file on your server
//     $bgColor = [255, 255, 255];
//     $textColor = [0, 0, 0];
//     $image = imagecreatetruecolor($width, $height);
//     $bgColor = imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);
//     $textColor = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);
//     imagefill($image, 0, 0, $bgColor);
//     $firstLetter = substr($name, 0, 1);
//     $textBox = imagettfbbox($fontSize, 0, $fontFile, $firstLetter);
//     $textWidth = $textBox[2] - $textBox[0];
//     $textHeight = $textBox[1] - $textBox[7];
//     $x = ($width - $textWidth) / 2;
//     $y = ($height - $textHeight) / 2;
//     imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontFile, $firstLetter);
//     $circleRadius = $width / 2;
//     $circleX = $circleRadius;
//     $circleY = $circleRadius;
//     $circleColor = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);
//     imagefilledellipse($image, $circleX, $circleY, $circleRadius * 2, $circleRadius * 2, $circleColor);
//     header('Content-Type: image/png');
//     imagepng($image);
//     imagedestroy($image);
//   }
// }