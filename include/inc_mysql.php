<?php

function fpiseu_dbconnect($user = false) {
  if ($user) {
    $link = mysqli_init();
    mysqli_options($link, MYSQLI_INIT_COMMAND, 'SET @FPISEU_USER = \''.$user.'\'');
    mysqli_real_connect($link, fpiseu_config('dbhost'), fpiseu_config('dbuser'), fpiseu_config('dbpass'), fpiseu_config('dbname'));
  } else {
    $link = @mysqli_connect( fpiseu_config('dbhost'), fpiseu_config('dbuser'), fpiseu_config('dbpass'), fpiseu_config('dbname'));
  }
  if (!$link) {
    $_SESSION['error'] = 'Connect Error (' . mysqli_connect_errno() . ') '
    . mysqli_connect_error();
    return false;
  }
  mysqli_set_charset($link, "latin1");
  return $link;
}

function fpiseu_dbclose($link) {
  if(!$link) return false;
  mysqli_close($link);
}

function fpiseu_dbquery($link, $query) {
  if(!$link) return false;
  return mysqli_query($link, $query);
}

function fpiseu_dbfree_result($result) {
  mysqli_free_result($result);
}

function fpiseu_dbfetch($result) {
  return mysqli_fetch_assoc($result);
}

function fpiseu_dbreset_result($result) {
  return mysqli_data_seek($result, 0);
}

function fpiseu_dberror($link, $ident = '') {
  if(!$link) return '';
  return $ident.'MySQL Error (' . mysqli_errno($link) . ') ' . mysqli_error($link);
}

function fpiseu_dbscape($link, $txt) {
  if(!$link) return '';
  return mysqli_real_escape_string($link,$txt);
}

function fpiseu_dblast_id($link) {
  if(!$link) return 0;
  return mysqli_insert_id($link);
}

function fpiseu_dbfetch_all($result) {
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function fpiseu_dbautocommit($link, $mode) {
  return mysqli_autocommit($link, $mode);
}

function fpiseu_dbinfo($link) {
  return mysqli_info($link);
}

function fpiseu_dbquery_json_error($link, $query, &$json, $tag = '') {
  if(!$link) return false;
  $result = fpiseu_dbquery($link, $query);
  if( ! $result )
    $json['errors'][] = $tag . ' ERROR: ' . fpiseu_dberror($link);
  return $result;
}

function fpiseu_dbwarning_json($link, &$json) {
  if (mysqli_warning_count($link)) {
    $warning = mysqli_get_warnings($link);
    do {
      $json['warnings'][] = '(' .$warning->errno . ') ' . $warning->message;
    } while ($warning->next());
  }
}

?>
