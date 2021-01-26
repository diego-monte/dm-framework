<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Libraries\BBcode;

use Core\Logs as Logs;

class BBcodeClass {

    private $log;

    public function __construct() {

        $this->log = new Logs\Log;

    }

    public function filter($obj) {

        $obj = strip_tags($obj);
        
		// BBcode array
		$find = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[s\](.*?)\[/s\]~s',
            '~\[center\](.*?)\[/center\]~s',
            '~\[left\](.*?)\[/left\]~s',
            '~\[right\](.*?)\[/right\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[code\](.*?)\[/code\]~s',
			'~\[size=([0-9]+)\](.*?)\[/size\]~s',
			'~\[color=([a-zA-Z0-9#]+)\](.*?)\[/color\]~s',
            '~\[url\]((?:ftp|https?)://[^\'"><]*?)\[/url\]~s',
            '~\[url=((?:ftp|https?)://[^\'"><]*?)\](.*?)\[/url\]~s',
            '~\[img\](https?://[^\'"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
            '~\[font=([a-zA-Z0-9 ]*)\](.*?)\[/font\]~s',
            '~\[list\](.*?)\[/list\]~s',
            '~\[\*\](.*)~',
            '~\[table\](.*?)\[/table\]~s',
            '~\[tr\](.*?)\[/tr\]~s',
            '~\[td\](.*?)\[/td\]~s',
            '~\[youtube\](?:ftp|https?):\/\/www.youtube.com\/watch\?v=([^\'"><]*?)\[/youtube\]~s',
            '~\[email\]([\w\.\-]+@[a-zA-Z0-9\-]+\.?[a-zA-Z0-9\-]*\.\w{1,4})\[/email\]~s',
            '~\[email=([\w\.\-]+@[a-zA-Z0-9\-]+\.?[a-zA-Z0-9\-]*\.\w{1,4})\]([^\'"><]*?)\[/email\]~s'
        );
        
		// HTML tags to replace BBcode
		$replace = array(
			'<span style="font-weight: bold;">$1</span>',
			'<span style="font-style: italic;">$1</span>',
            '<span style="text-decoration:underline;">$1</span>',
            '<span style="text-decoration: line-through;">$1</span>',
            '<div style="text-align: center;">$1</div>',
            '<div style="text-align: left;">$1</div>',
            '<div style="text-align: right;">$1</div>',
            '<blockquote><p>$1</p></blockquote>',
			'<pre>$1</pre>',
			'<span style="font-size:$1px;">$2</span>',
			'<span style="color:$1;">$2</span>',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>',
            '<img src="$1" alt="" />',
            '<span style="font-family:$1">$2</span>',
            '<ul>$1</ul>',
            '<li>$1</li>',
            '<table>$1</table>',
            '<tr>$1</tr>',
            '<td>$1</td>',
            '<iframe class="youtube-player" type="text/html" width="100%" height="100%" src="https://www.youtube.com/embed/$1" frameborder="0"></iframe>',
            '<a href="mailto:$1">$1</a>',
            '<a href="mailto:$1">$2</a>'
            
		);
		// Replacing the BBcodes with corresponding HTML tags
        return preg_replace($find, $replace, $obj);
        
	}

}