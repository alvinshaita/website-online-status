<?php

namespace rezozero\monitor\view;

use rezozero\monitor\engine;
use rezozero\monitor\kernel\Router;

class TableOutput
{
    private $header = "";
    private $footer = "";
    private $content = "";

    private static $columnWidth = array(
        'url' => 60,
        'status' => 6,
    );

    public function __construct()
    {
        system("clear");

        $this->header();
        $this->footer();

    }

    public function header()
    {
        return "<table id='rz-monitor-statuses'>";
    }

    public function footer()
    {
        return "</table>";
    }

    public function content($html)
    {
        $this->content .= $html;
        return $this->content;
    }

    public function parseArray($arr)
    {

        foreach ($arr as $ckey => $crawler) {

            if ($ckey == 0) {
                continue;
            }
            ksort($crawler);

            $this->content("<tr>");
            foreach ($crawler as $key => $value) {

                /*
                 * If not in column width donot display
                 */
                if (!in_array($key, array_keys(static::$columnWidth))) {
                    continue;
                }

                $width = null;
                $style = null;

                switch (strtolower($key)) {
                    case 'status':
                        if ($value == \rezozero\monitor\engine\Crawler::STATUS_ONLINE) {
                            $value = "<img width='16' src='" . Router::getResolvedBaseUrl() . "img/iconOnline.png' />";

                            $style = "background-color:green;width:16px;";
                        } else if ($value == \rezozero\monitor\engine\Crawler::STATUS_DOWN) {
                            $value = "<img width='16' src='" . Router::getResolvedBaseUrl() . "img/iconDown.png' />";
                            $style = "background-color:red;width:16px;";
                        } else {
                            $value = "<img width='16' src='" . Router::getResolvedBaseUrl() . "img/iconFailed.png' />";
                            $style = "background-color:orange;width:16px;";
                        }
                        break;
                    case 'time':
                        $value = sprintf('%1.3fs', (float) $value);
                        break;
                    case 'totalTime':
                        $value = sprintf('%1.3fs', (float) $value);
                        break;
                    case 'avg':
                        $value = sprintf('%1.3fs', (float) $value);
                        break;
                    case 'url':
                        $style = "font-size:16px;";
                        $value = str_replace("http://", "", $value);
                        $value = str_replace("https://", "", $value);
                        $value = str_replace("www.", "", $value);
                        $value = str_replace(".com", "", $value);
                        $value = str_replace(".net", "", $value);
                        $value = str_replace(".org", "", $value);
                        $value = str_replace(".eu", "", $value);
                        $value = str_replace(".fr", "", $value);
                        break;

                    default:
                        # code...
                        break;
                }

                $this->content("<td class='" . $key . "'");
                if ($width !== null) {
                    $this->content(" style='width:" . $width . "px; height:16px;'");
                } else if ($style !== null) {
                    $this->content(" style='" . $style . " height:16px;'");
                } else {
                    $this->content(" style='height:16px;'");
                }
                $this->content(">" . $value . "</td>");
            }

            $this->content("</tr>");
        }
    }

    public function output()
    {
        return $this->header() . $this->content . $this->footer() . "\n\n";
    }

    public function flushContent()
    {
        $this->content = '';
        return true;
    }
}
