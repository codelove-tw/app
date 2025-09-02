<?php

namespace App;

class AppCore
{
    protected $openGraphTitle = null;

    protected $openGraphDescription = null;

    protected $openGraphImage = null;

    public function setOpenGraphTitle($title)
    {
        $this->openGraphTitle = $title;
    }

    public function setOpenGraphDescription($description)
    {
        $this->openGraphDescription = $description;
    }

    public function setOpenGraphImage($image)
    {
        $this->openGraphImage = $image;
    }

    public function getOpenGraphTitle()
    {
        if ($this->openGraphTitle) {
            return $this->openGraphTitle;
        }

        return '';
    }

    public function getOpenGraphDescription()
    {
        if ($this->openGraphDescription) {
            return $this->openGraphDescription;
        }

        return '';
    }

    public function getOpenGraphImage()
    {
        if ($this->openGraphImage) {
            return $this->openGraphImage;
        }

        return '';
    }
}
