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
     * @param Browser $buzz
     */
    public function __construct(Browser $buzz)
    {
        $this->buzz = $buzz;
    }

    private function my_file_get_contents($url)
    {
//        exec('curl ' . $url, $output);
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
        $url = 'http://thepiratebay.sx/search/' . $data . '/0/7/0';
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