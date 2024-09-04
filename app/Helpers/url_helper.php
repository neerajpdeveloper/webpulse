<?php

if (! function_exists('template')) {
    function template(string $module, string $view, array $data = []) {
        echo view('app_top', $data);
        echo view('app_header', $data);
        echo view("App\Modules{$module}\Views{$view}", $data);
        echo view('app_bottom', $data);
    }
}

if (! function_exists('admin_template')) {
    function admin_template(string $module, string $view, array $data = []) {
        echo view("App\Modules{$module}\Views\include\app_top", $data);
        echo view("App\Modules{$module}\Views\\{$view}", $data);
        echo view("App\Modules{$module}\Views\include\app_bottom", $data);
    }
}

if (!function_exists('safe_update')) {
    function safe_update($table, $data = [], $where) {
        db_connect()->table($table)->where($where)->set($data)->update();
    }
}


if (!function_exists('get_single_row')) {
  function get_single_row($table, $id, $primary_key) {
    return db_connect()->table($table)->where($primary_key,$id)->get()->getRow();
  }
}

if (!function_exists('getData')) {
  function getData($table, $where = null) {
    $db = db_connect();
    $query = $db->table($table);
    if ($where != null) {  $query->where($where); }
    return $query->get()->getResult();
    
  }
}

if (!function_exists('update_displayOrder')) {
  function update_displayOrder($table, $data = [], $where) {
      db_connect()->table($table)->where($where)->set($data)->update();
  }
}

if (!function_exists('cat_count')) {
    function cat_count(int $catid) {
        return db_connect()->table('wps_categories')->where('parent_id', $catid)->countAllResults() ?: 0;
    }
}

if (!function_exists('cat_product')) {
    function cat_product($catid) {
        return db_connect()->table('wps_products')->where($catid)->countAllResults() ?: 0;
    }
}


if (!function_exists('cat_faq')) {
  function cat_faq($catid) {
      return db_connect()->table('wps_faq')->where('category_id',$catid)->countAllResults() ?: 0;
  }
}

if (!function_exists('loc_count')) {
  function loc_count(int $id) {
      return db_connect()->table('wps_location')->where('parent_id',$id)->countAllResults() ?: 0;
  }
}

if (!function_exists('admin_url')) {
    function admin_url($uri = '') {
        return base_url("wpsadmin/$uri");
    }
}

if (!function_exists('getDatabaseData')) {
  function getDatabaseData($table)
  {
      $db = db_connect();
      $result = $db->table($table)->get()->getResult();
      return json_decode(json_encode($result), true);
  }
}

if (!function_exists('removeImage')) {
  function removeImage($cfgs) {
    if ($cfgs['source_dir'] != '' && $cfgs['source_file'] != '') {
      $pathImage = UPLOAD_DIR . "/" . $cfgs['source_dir'] . "/" . $cfgs['source_file'];
      if (file_exists($pathImage)) {
        unlink($pathImage);
      }
    }
  }

}



if (!function_exists('get_nested_dropdown_menu')) {
  function get_nested_dropdown_menu($parent, $selectId = "", $pad = "|_") {
      $selId = ( $selectId != "" ) ? $selectId : "";
      $var = "";
      $db = db_connect();
      $query = $db->query("SELECT * FROM wps_categories WHERE parent_id=$parent AND status='1'");
      $num_rows = $query->getNumRows();
      if ($num_rows > 0) {
          foreach ($query->getResultArray() as $row) {
              $category_name = ucfirst(strtolower($row['category_name']));
              $has_child_query = $db->query("SELECT * FROM wps_categories WHERE parent_id={$row['category_id']} AND status='1'");
              $has_child = ($has_child_query->getNumRows() > 0);
              if ($has_child) {
                  $var .= '<legend style="font-size:15px">'.$pad.$category_name.'</legend>';
                  $var .= '<div class="row">'.get_nested_dropdown_menu($row['category_id'], $selId,$pad).'</div>';
              } else {
                  $sel = (in_array($row['category_id'], explode(',', $selectId))) ? "checked='checked'" : "";
                  $var .='<div class="col-md-4"><input type="checkbox" name="category_id[]" value="'.$row['category_id'].'" '.$sel.' > '.$category_name.'</div>';
              }
          }
      }
      return $var;
  }
}


if (!function_exists('getLeaddateStatus')) {
  function getLeaddateStatus($receive_date) {
    // Convert the lead date to a timestamp
    $leadTimestamp = strtotime($receive_date);
    // Get today's date
    $today = date('Y-m-d');
    // Get yesterday's date
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    // Determine the lead status based on when it was received
    if (date('Y-m-d', $leadTimestamp) == $today) {
      // Lead was received today
      $leadStatus = 'Today at ' . date('h:i A', $leadTimestamp);
    } elseif (date('Y-m-d', $leadTimestamp) == $yesterday) {
      // Lead was received yesterday
      $leadStatus = 'Yesterday at ' . date('h:i A', $leadTimestamp);
    } else {
      // Lead was received on an earlier date
      $leadStatus = date('F j, Y', $leadTimestamp) . ' at ' . date('h:i A', $leadTimestamp);
    }
    // Return the lead status
    return $leadStatus;
  }
}



/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if (!function_exists('seo_friendly_url')) {

  function seo_friendly_url($str, $separator = 'dash', $lowercase = TRUE) {
    $foreign_characters = array(
      '/ä|æ|ǽ/' => 'ae',
      '/ö|œ/' => 'oe',
      '/ü/' => 'ue',
      '/Ä/' => 'Ae',
      '/Ü/' => 'Ue',
      '/Ö/' => 'Oe',
      '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|А/' => 'A',
      '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|а/' => 'a',
      '/Б/' => 'B',
      '/б/' => 'b',
      '/Ç|Ć|Ĉ|Ċ|Č|Ц/' => 'C',
      '/ç|ć|ĉ|ċ|č|ц/' => 'c',
      '/Ð|Ď|Đ|Д/' => 'D',
      '/ð|ď|đ|д/' => 'd',
      '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Е|Ё|Э/' => 'E',
      '/è|é|ê|ë|ē|ĕ|ė|ę|ě|е|ё|э/' => 'e',
      '/Ф/' => 'F',
      '/ф/' => 'f',
      '/Ĝ|Ğ|Ġ|Ģ|Г/' => 'G',
      '/ĝ|ğ|ġ|ģ|г/' => 'g',
      '/Ĥ|Ħ|Х/' => 'H',
      '/ĥ|ħ|х/' => 'h',
      '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|И/' => 'I',
      '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|и/' => 'i',
      '/Ĵ|Й/' => 'J',
      '/ĵ|й/' => 'j',
      '/Ķ|К/' => 'K',
      '/ķ|к/' => 'k',
      '/Ĺ|Ļ|Ľ|Ŀ|Ł|Л/' => 'L',
      '/ĺ|ļ|ľ|ŀ|ł|л/' => 'l',
      '/М/' => 'M',
      '/м/' => 'm',
      '/Ñ|Ń|Ņ|Ň|Н/' => 'N',
      '/ñ|ń|ņ|ň|ŉ|н/' => 'n',
      '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|О/' => 'O',
      '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|о/' => 'o',
      '/П/' => 'P',
      '/п/' => 'p',
      '/Ŕ|Ŗ|Ř|Р/' => 'R',
      '/ŕ|ŗ|ř|р/' => 'r',
      '/Ś|Ŝ|Ş|Š|С/' => 'S',
      '/ś|ŝ|ş|š|ſ|с/' => 's',
      '/Ţ|Ť|Ŧ|Т/' => 'T',
      '/ţ|ť|ŧ|т/' => 't',
      '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|У/' => 'U',
      '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|у/' => 'u',
      '/В/' => 'V',
      '/в/' => 'v',
      '/Ý|Ÿ|Ŷ|Ы/' => 'Y',
      '/ý|ÿ|ŷ|ы/' => 'y',
      '/Ŵ/' => 'W',
      '/ŵ/' => 'w',
      '/Ź|Ż|Ž|З/' => 'Z',
      '/ź|ż|ž|з/' => 'z',
      '/Æ|Ǽ/' => 'AE',
      '/ß/' => 'ss',
      '/Ĳ/' => 'IJ',
      '/ĳ/' => 'ij',
      '/Œ/' => 'OE',
      '/ƒ/' => 'f',
      '/Ч/' => 'Ch',
      '/ч/' => 'ch',
      '/Ю/' => 'Ju',
      '/ю/' => 'ju',
      '/Я/' => 'Ja',
      '/я/' => 'ja',
      '/Ш/' => 'Sh',
      '/ш/' => 'sh',
      '/Щ/' => 'Shch',
      '/щ/' => 'shch',
      '/Ж/' => 'Zh',
      '/ж/' => 'zh',
  );


    $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);
    
    $replace = ($separator == 'dash') ? '-' : '_';
    $trans = array(
        '&\#\d+?;' => '',
        '&\S+?;' => '',
        '\s+' => $replace,
        '[^a-z0-9\-\._]' => '',
        $replace . '+' => $replace,
        $replace . '$' => $replace,
        '^' . $replace => $replace,
        '\.+$' => ''
    );
    $str = strip_tags($str);
    foreach ($trans as $key => $val) {
      $str = preg_replace("#" . $key . "#i", $val, $str);
    }
    if ($lowercase === TRUE) {
      if (function_exists('mb_convert_case')) {
        $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
      } else {
        $str = strtolower($str);
      }
    }
    return trim(stripslashes($str));
  }

}

?>
