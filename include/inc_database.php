<?php

require_once 'inc_mysql.php';

function fpiseu_database_selectby_table($dblink, $table, $return_result = true, &$data = false, &$info = false) {
  $order = '';
  $inner = '';
  /* Default Operation */
  $operation = "SELECT * FROM `$table`";

  if($data) {
    /* Check if we want to order */
    if(isset($data['order'])) {
      $order = 'ORDER BY ' . $data['order'];
      unset($data['order']);
    }
    /* Check Inner Table */
    if(isset($data['inner'])) {
      $tbl2 = &$data['inner'];
      $tbl2['field2'] = (isset($tbl2['field2'])?$tbl2['field2']:$tbl2['field1']);
      $inner = 'INNER JOIN `' . $tbl2['table'] . '` ON ( `' . $table . '`.`' . $tbl2['field1'] . '`=`' . $tbl2['table'] . '`.`' . $tbl2['field2'] . '` )';
      unset($data['inner'], $tbl2);
    }
    if(isset($data['delete'])) {
      $operation = "DELETE FROM `$table`";
      unset($data['delete']);
    }
  }

  /* Check if we want to update */
  if($info) {
    if(isset($info['keys']) && isset($info['insert'])) {
      $operation = "INSERT INTO `$table` (" . implode(' , ', array_keys($info['keys'])) . ') VALUES (' . implode(' , ', $info['keys']) . ')';
      unset($info['insert']);
    } else if(isset($info['keys']) && isset($info['replace'])) {
      $operation = "REPLACE INTO `$table` (" . implode(' , ', array_keys($info['keys'])) . ') VALUES (' . implode(' , ', $info['keys']) . ')';
      unset($info['replace']);
    } else if(isset($info['keys']) && isset($info['on_dup_up'])) {
      $operation = "INSERT INTO `$table` (" . implode(' , ', array_keys($info['keys'])) . ') VALUES (' . implode(' , ', $info['keys']) . ')'
      . 'ON DUPLICATE KEY UPDATE ' . implode(' , ', $info['pair']);
      unset($info['on_dup_up']);
    } else {
      $operation = "UPDATE `$table` SET " . implode(' , ', $info);
    }
  }

  /* Need to check data again in case is empty. */
  $where = ($data?'WHERE ' . implode(' AND ', $data):'');
  /* Execute the Query. */
  $result = fpiseu_dbquery($dblink,"$operation $inner $where $order;");
  if($result) {
    /* Insert or Update return last id */
    if($info) {
      return fpiseu_dblast_id($dblink);
    }
    if($return_result) {
      return $result;
    } else {
      $fetch_all = fpiseu_dbfetch_all($result);
      fpiseu_dbfree_result($result);
      return $fetch_all;
    }
  } else {
    $_SESSION['error'] = fpiseu_dberror($dblink);
  }
  return false;
}

function fpiseu_database_post2field(&$data, $field , &$dblink = false, $type = false, $post = false, $isempty = false, &$source = false ) {
  if(! $post ) $post = $field;
  if(! $source ) $source = &$_POST;
  if (isset($source[$field]) && ( $isempty || !empty($source[$field]) ) ) {
    switch ($type) {
      case _FPISEU_DATABASE_LIKE_:
        $data[] = "`$field`LIKE '%" . ($dblink ? fpiseu_dbscape($dblink, $source[$field]) : $source[$field]) . "%'";
        break;
      case _FPISEU_DATABASE_KEY_:
        $data['keys'][$field] = "'" . ($dblink ? fpiseu_dbscape($dblink, $source[$field]) : $source[$field]) . "'";
        break;
      case _FPISEU_DATABASE_DUP_:
        $data['keys'][$field] = "'" . ($dblink ? fpiseu_dbscape($dblink, $source[$field]) : $source[$field]) . "'";
        $data['pair'][] = "`$field`='" . ($dblink ? fpiseu_dbscape($dblink, $source[$field]) : $source[$field]) . "'";
        break;
      default:
        $data[] = "`$field`='" . ($dblink ? fpiseu_dbscape($dblink, $source[$field]) : $source[$field]) . "'";
    }
  }
}

?>
