<?php

namespace App\Message;

class NewsParser
{
    private $title;
    private $shortDescription;
    private $picture;
    
    public function __construct(string $title,string $shortDescription,string $picture)
    {
        $this->title = $title;
        $this->shortDescription = $shortDescription;
        $this->picture = $picture;
    }

    /** 
     * @return string
     * 
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** 
     * @return string
     * 
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /** 
     * @return string
     * 
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

}