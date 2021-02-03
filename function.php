<?php
function slugify($text){
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}
function add_href($matches){
  return '<li class="toc'.$matches[1].'"><a href="#'.slugify($matches[2]).'">'.$matches[2].'</a></li>';
}
function add_htag($matches){
  return '<h'.$matches[1].' id="'.url_slug($matches[2]).'">'.$matches[2].'</h'.$matches[1].'>';
}
function TableOfContents($content, $depth){
  $pattern = '/<h[1-'.$depth.']*[^>]*>.*?<\/h[1-'.$depth.']>/';
  $whocares = preg_match_all($pattern,$content,$winners);
  if (count($winners[0])>=3) {
    $heads = implode("\n",$winners[0]);
    $heads = preg_replace_callback('#<h([1-'.$depth.'])>(.*?)<\/h[1-'.$depth.']>#si', 'add_href', $heads);
    $contents = '<div id="content"> 
    <b><em>&nbsp;</em> <i>Contents:</i></b>
    <div class="clear"></div>
    <ul>
    '.$heads.'
    </ul>
    </div>';
    return $contents;
  }else{
    return '';
  }
}
function Insert_htag($content, $depth){
  $heads = preg_replace_callback('#<h([1-'.$depth.'])>(.*?)<\/h[1-'.$depth.']>#si', 'add_htag', $content);
  return $heads;
}
