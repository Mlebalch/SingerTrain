<?php

namespace App\Lib;


use Exception;
use RuntimeException;
use Imagick;


class Pixelisation
{
    public function startUrl(string $url, float $valuex)
    {
        try {
            // Télécharger l'image depuis l'URL
            $imageData = file_get_contents($url);
            if ($imageData === false) {
                throw new RuntimeException("Erreur lors du téléchargement de l'image");
            }

            // Sauvegarder l'image téléchargée temporairement
            $tempImagePath = "../ressources/front/temp_image.jpg";
            file_put_contents($tempImagePath, $imageData);

            // Charger l'image avec Imagick
            $imagick = new Imagick($tempImagePath);
            if ($imagick === false) {
                throw new RuntimeException("Erreur lors de la création de l'image");
            }

            // Pixeliser l'image
            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();
            $imagick->scaleImage($width * $valuex, $height * $valuex);
            $imagick->scaleImage($width, $height);

            // Sauvegarder l'image pixelisée
            $imagick->writeImage("../ressources/front/ImagedeBase.jpg");

            // Libérer les ressources
            $imagick->clear();
            $imagick->destroy();

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    // Other methods remain unchanged


    public function start(float $valuex)
    {
        try {
            // Charger l'image existante
            $originalImage = imagecreatefromjpeg("../../front/ImagedeBase.jpg");
            if ($originalImage === false) {
                throw new RuntimeException("Erreur lors du chargement de l'image");
            }

            $this->createPixelStade1($valuex, $originalImage);

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }


    public function createPixelStade1(float $valuex, $originalImage)
    {
        $width = imagesx($originalImage);
        $height = imagesy($originalImage);
        $value = intval(floor($width * $valuex));

        for ($i = 0; $i < $width; $i += $value) {
            for ($y = 0; $y < $height; $y += $value) {
                $rgb = $this->avgRGB($originalImage, $i, $y, $value);
                $this->colorsImage($originalImage, $rgb, $value, $i, $y);
            }
        }

        // Sauvegarder l'image pixelisée
        imagejpeg($originalImage, "../../front/ImagePixelise.jpg");
        echo "Fini";
    }

    public function colorsImage($originalImage, int $rgb, int $value, int $x, int $y)
    {
        for ($i = 0; $i < $value; $i++) {
            for ($j = 0; $j < $value; $j++) {
                if (($x + $i) < imagesx($originalImage) && ($y + $j) < imagesy($originalImage)) {
                    imagesetpixel($originalImage, $x + $i, $y + $j, $rgb);
                }
            }
        }
    }

    public function avgRGB($originalImage, int $x, int $y, int $value): int
    {
        $r = 0;
        $g = 0;
        $b = 0;
        $pixelsRead = 0;

        for ($i = 0; $i < $value; $i++) {
            for ($j = 0; $j < $value; $j++) {
                if (($x + $i) < imagesx($originalImage) && ($y + $j) < imagesy($originalImage)) {
                    $rgb = imagecolorat($originalImage, $x + $i, $y + $j);
                    $components = $this->getRGBComponents($rgb);
                    $r += $components[0];
                    $g += $components[1];
                    $b += $components[2];
                    $pixelsRead++;
                }
            }
        }

        if ($pixelsRead > 0) {
            $r = intval($r / $pixelsRead);
            $g = intval($g / $pixelsRead);
            $b = intval($b / $pixelsRead);
        } else {
            $r = $g = $b = 255; // Valeur par défaut en cas d'erreur
        }

        return ($r << 16) | ($g << 8) | $b;
    }

    public function getRGBComponents(int $rgb): array
    {
        $red = ($rgb >> 16) & 0xFF;
        $green = ($rgb >> 8) & 0xFF;
        $blue = $rgb & 0xFF;

        return [$red, $green, $blue];
    }
}
?>