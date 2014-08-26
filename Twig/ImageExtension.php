<?php

namespace InfiniteDevelopers\Base64Bundle\Twig;

use Symfony\Component\HttpFoundation\File\File;

class ImageExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('image64', array($this, 'image64'))
        );
    }

    /**
     * Transform image to base 64
     * @param  string $path relative path to image from bundle directory
     * @return string       base64 encoded image
     */
    public function image64($path)
    {
        $path = __DIR__.'/../'.$path;
        
        $file = new File($path, false);
        
        if (!$file->isFile() || 0 !== strpos($file->getMimeType(), 'image/')) {
            return;
        }
        
        $binary = file_get_contents($path);
        
        return sprintf('data:image/%s;base64,%s', $file->guessExtension(), base64_encode($binary));
    }

    public function getName()
    {
        return 'image_extension';
    }
}