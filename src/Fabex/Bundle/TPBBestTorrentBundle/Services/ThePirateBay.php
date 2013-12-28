<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 4:50 AM
 */

namespace Fabex\Bundle\TPBBestTorrentBundle\Services;

use Buzz\Browser;

class ThePirateBay
{
    /**
     * @var \Buzz\Browser
     */
    private $buzz;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param Browser $buzz
     */
    public function __construct(Browser $buzz, $uri)
    {
        $this->buzz = $buzz;
        $this->uri = $uri;
    }

    private function my_file_get_contents($url)
    {
        $response = $this->buzz->get($url, array('User-Agent'=>'Firefox'));
        return $response->getContent();
    }

    public function getTorrent($serie, $number)
    {
        $serie = preg_replace('/\(\d+\)/', '', $serie); //--> hack to remove year in ()
        return $this->getBetterTorrent($serie . ' ' . $number);
    }

    public function searchTorrent($episode)
    {
        return $this->getBetterTorrent($episode);
    }

    private function getBetterTorrent($data)
    {
        $data = urlencode($data);
        $url = $this->uri.'/search/' . $data . '/0/7/0';
        $html = $this->my_file_get_contents($url);
        $pattern = "/href=\"(magnet\:.*)\" title/U";
        $matches = array();
        $str = preg_match($pattern, $html, $matches);
        if ($str) {
            return $matches[1];
        } else {
            return '';
        }
    }
}