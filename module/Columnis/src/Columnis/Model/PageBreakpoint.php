<?php

namespace Columnis\Model;

use Columnis\Exception\Templates\PathNotFoundException;

class PageBreakpoint {

    const BREAKPOINT_FILE = 'breakpoints.tpl';
    const BREAKPOINT_DIR = 'breakpoints';

    protected $idPage;
    protected $hash;
    protected $images;
    protected $path;
    protected $imageGroupsSizes;

    /**
     * Returns the images array
     *
     * @return array
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Returns the imagegroups sizes groups array
     *
     * @return array
     */
    public function getImageGroupsSizes() {
        return $this->imageGroupsSizes;
    }

    /**
     * Returns page id
     *
     * @return int
     */
    public function getIdPage() {
        return $this->idPage;
    }

    /**
     * Returns breakpoints hash
     *
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    /**
     * Return the path of breakpoint file
     * @return string
     */
    function getPath() {
        return $this->path;
    }

    /**
     * Sets the page id
     *
     * @param int $idPage
     */
    public function setIdPage($idPage) {
        $this->idPage = $idPage;
    }

    /**
     * Sets the breackpoint hash
     *
     * @param string $hash
     */
    public function setHash($hash) {
        $this->hash = $hash;
    }

    /**
     * Sets the path of the breakpoint file
     *
     * @param string $path
     * @throws PathNotFoundException
     */
    public function setPath($path) {
        if($path === null) {
            throw new PathNotFoundException('Path can not be null.');
        }
        $absPath = realpath($path);
        if(!$absPath) {
            throw new PathNotFoundException('Path: '.$path.' does not exist.');
        }
        $this->path = $absPath;
    }

    /**
     * Sets the images array
     * @param array $images
     */
    public function setImages($images) {
        $this->images = $images;
    }

    /**
     * Sets the imagegroups sizes array
     * @param array $imageGroupsSizes
     *
     */
    public function setImageGroupsSizes($imageGroupsSizes) {
        $this->imageGroupsSizes = $imageGroupsSizes;
    }

    /**
     * Returns breakpoint file name
     * @return string
     */
    public function getFileName() {
        return $this->getIdPage().'-'.$this->getHash().'.css';
    }

    /**
     * Returns breakpoint full path
     * @return string
     */
    public function getFullPath() {
        return $this->getPath().DIRECTORY_SEPARATOR.self::BREAKPOINT_DIR.DIRECTORY_SEPARATOR;
    }

    /**
     * Return an array with the util data
     * 
     * @return array
     */
    public function getData() {
        $data = array(
            'idPage' => $this->getIdPage(),
            'images' => $this->getImages(),
            'imagesGroupsSizes' => $this->getImageGroupsSizes()
        );
        return $data;
    }

    /**
     * Returns breakpoint full file name
     * @return string
     */
    public function getFullFileName() {
        return $this->getFullPath().$this->getFileName();
    }
}

?>