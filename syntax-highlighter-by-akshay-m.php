<?php
/*
 * Plugin Name: Syntax Highlighter by Akshay M.
 * Plugin URI: http://www.rubyinrails.com
 * Description: Plugin that allows syntax highlightening of your code in markup languagges, ruby, java, cpp, c, php etc.
 * Version: 1.0
 * Author: Akshay Mohite
 * Author URI: http://www.rubyinrails.com
 * License: GPL2

    Copyright (c) 2014 Akshay Mohite

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
    
*/

add_action('wp_enqueue_scripts', 'load_styles');
/**
 * [load_styles description]
 * @return [type] [description]
 */
function load_styles()
{
    wp_enqueue_script( 'prism_js', plugins_url( '/js/prism.js' , __FILE__ ) , array( 'jquery' ), NULL, true );
    wp_enqueue_style( 'prism_css', plugins_url( '/css/prism.css' , __FILE__ ) );
}

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );
remove_filter('the_content', 'wptexturize');

remove_filter('comment_text', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');

add_shortcode( 'html' , 'hightlight_html' );
add_shortcode( 'css' , 'hightlight_css' );
add_shortcode( 'javascript' , 'hightlight_javascript' );
add_shortcode( 'php' , 'hightlight_php' );
add_shortcode( 'ruby' , 'hightlight_ruby' );
add_shortcode( 'java' , 'hightlight_java' );
add_shortcode( 'cpp' , 'hightlight_cpp' );
add_shortcode( 'c' , 'hightlight_c' );

function hightlight_html($atts, $content = null)
{
    return encode_content('html', $content);
}

function hightlight_css($atts, $content = null)
{
    return encode_content('css', $content);
}

function hightlight_javascript($atts, $content = null)
{
    return encode_content('javascript', $content);
}

function hightlight_php($atts, $content = null)
{
    return encode_content('php', $content);
}
function hightlight_ruby($atts, $content = null)
{
    return encode_content('ruby', $content);
}
function hightlight_java($atts, $content = null)
{
    return encode_content('ruby', $content);
}
function hightlight_cpp($atts, $content = null)
{
    return encode_content('ruby', $content);
}
function hightlight_c($atts, $content = null)
{
    return encode_content('ruby', $content);
}
function encode_content($lang, $content)
{
    $find_array = array( '&#91;', '&#93;' );
    $replace_array = array( '[', ']' );

    $content = preg_replace_callback( '|(.*)|isU', 'pre_entities', trim( str_replace( $find_array, $replace_array, $content ) ) );

    $content = str_replace('#038;', '', $content);

    return sprintf('<pre class="language-%s"><code>%s</code></pre>', $lang, $content);
}

function pre_entities( $matches ) {
    return str_replace( $matches[1], htmlspecialchars( $matches[1]), $matches[0] );
}

?>