<?php

echo "\nTesting OCI8 support\n\n";

$GLOBALS['failed-count'] = 0;
$pad_len = 40;

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_QUIET_EVAL, 1);

function assertHandler($file, $line, $code, $description = null) {
    echo <<<TXT
Assertion failed:
    File: {$file}
    Line: {$line}
    Code: {$code}
TXT;
    $GLOBALS['failed-count']++;
}
assert_options(ASSERT_CALLBACK, 'assertHandler');

//////////////////////////////////////////////////////////////////////////////
// Test defined constants
//////////////////////////////////////////////////////////////////////////////

echo str_pad("Testing defined constants... ", $pad_len);

assert(defined('OCI_ASSOC'), 'Constant "OCI_ASSOC" missing. Used with oci_fetch_all() and oci_fetch_array() to get results as an associative array.');
assert(defined('OCI_BOTH'), 'Constant "OCI_BOTH" missing. Used with oci_fetch_all() and oci_fetch_array() to get results as an array with both associative and number indices.');
assert(defined('OCI_COMMIT_ON_SUCCESS'), 'Constant "OCI_COMMIT_ON_SUCCESS" missing. Statement execution mode for oci_execute() call. Automatically commit changes when the statement has succeeded.');
assert(defined('OCI_CRED_EXT'), 'Constant "OCI_CRED_EXT" missing. Used with oci_connect() for using Oracles\' External or OS authentication. Introduced in PHP 5.3 and PECL OCI8 1.3.4.');
assert(defined('OCI_DEFAULT'), 'Constant "OCI_DEFAULT" missing. See OCI_NO_AUTO_COMMIT.');
assert(defined('OCI_DESCRIBE_ONLY'), 'Constant "OCI_DESCRIBE_ONLY" missing. Statement execution mode for oci_execute(). Use this mode if you want meta data such as the column names but don\'t want to fetch rows from the query.');
assert(defined('OCI_EXACT_FETCH'), 'Constant "OCI_EXACT_FETCH" missing. Obsolete. Statement fetch mode. Used when the application knows in advance exactly how many rows it will be fetching. This mode turns prefetching off for Oracle release 8 or later mode. The cursor is canceled after the desired rows are fetched which may result in reduced server-side resource usage.');
assert(defined('OCI_FETCHSTATEMENT_BY_COLUMN'), 'Constant "OCI_FETCHSTATEMENT_BY_COLUMN" missing. Default mode of oci_fetch_all().');
assert(defined('OCI_FETCHSTATEMENT_BY_ROW'), 'Constant "OCI_FETCHSTATEMENT_BY_ROW" missing. Alternative mode of oci_fetch_all().');
assert(defined('OCI_LOB_BUFFER_FREE'), 'Constant "OCI_LOB_BUFFER_FREE" missing. Used with OCI-Lob::flush to free buffers used.');
assert(defined('OCI_NO_AUTO_COMMIT'), 'Constant "OCI_NO_AUTO_COMMIT" missing. Statement execution mode for oci_execute(). The transaction is not automatically committed when using this mode. For readability in new code, use this value instead of the older, equivalent OCI_DEFAULT constant. Introduced in PHP 5.3.2 (PECL OCI8 1.4).');
assert(defined('OCI_NUM'), 'Constant "OCI_NUM" missing. Used with oci_fetch_all() and oci_fetch_array() to get results as an enumerated array.');
assert(defined('OCI_RETURN_LOBS'), 'Constant "OCI_RETURN_LOBS" missing. Used with oci_fetch_array() to get the data value of the LOB instead of the descriptor.');
assert(defined('OCI_RETURN_NULLS'), 'Constant "OCI_RETURN_NULLS" missing. Used with oci_fetch_array() to get empty array elements if the row items value is NULL.');
assert(defined('OCI_SEEK_CUR'), 'Constant "OCI_SEEK_CUR" missing. Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SEEK_END'), 'Constant "OCI_SEEK_END" missing. Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SEEK_SET'), 'Constant "OCI_SEEK_SET" missing. Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SYSDATE'), 'Constant "OCI_SYSDATE" missing. Obsolete.');
assert(defined('OCI_SYSDBA'), 'Constant "OCI_SYSDBA" missing. Used with oci_connect() to connect with the SYSDBA privilege. The php.ini setting oci8.privileged_connect should be enabled to use this.');
assert(defined('OCI_SYSOPER'), 'Constant "OCI_SYSOPER" missing. Used with oci_connect() to connect with the SYSOPER privilege. The php.ini setting oci8.privileged_connect should be enabled to use this.');
assert(defined('OCI_TEMP_BLOB'), 'Constant "OCI_TEMP_BLOB" missing. Used with OCI-Lob::writeTemporary to indicate that a temporary BLOB should be created.');
assert(defined('OCI_TEMP_CLOB'), 'Constant "OCI_TEMP_CLOB" missing. Used with OCI-Lob::writeTemporary to indicate that a temporary CLOB should be created.');
assert(defined('OCI_B_BFILE'), 'Constant "OCI_B_BFILE" missing. Used with oci_bind_by_name() when binding BFILEs.');
assert(defined('OCI_B_BIN'), 'Constant "OCI_B_BIN" missing. Used with oci_bind_by_name() to bind RAW values.');
assert(defined('OCI_B_BLOB'), 'Constant "OCI_B_BLOB" missing. Used with oci_bind_by_name() when binding BLOBs.');
assert(defined('OCI_B_CFILEE'), 'Constant "OCI_B_CFILEE" missing. Used with oci_bind_by_name() when binding CFILEs.');
assert(defined('OCI_B_CLOB'), 'Constant "OCI_B_CLOB" missing. Used with oci_bind_by_name() when binding CLOBs.');
assert(defined('OCI_B_CURSOR'), 'Constant "OCI_B_CURSOR" missing. Used with oci_bind_by_name() when binding cursors, previously allocated with oci_new_descriptor().');
assert(defined('OCI_B_INT'), 'Constant "OCI_B_INT" missing. Used with oci_bind_array_by_name() to bind arrays of INTEGER.');
assert(defined('OCI_B_NTY'), 'Constant "OCI_B_NTY" missing. Used with oci_bind_by_name() when binding named data types. Note: in PHP < 5.0 it was called OCI_B_SQLT_NTY.');
assert(defined('OCI_B_NUM'), 'Constant "OCI_B_NUM" missing. Used with oci_bind_array_by_name() to bind arrays of NUMBER.');
assert(defined('OCI_B_ROWID'), 'Constant "OCI_B_ROWID" missing. Used with oci_bind_by_name() when binding ROWIDs.');
assert(defined('SQLT_AFC'), 'Constant "SQLT_AFC" missing. Used with oci_bind_array_by_name() to bind arrays of CHAR.');
assert(defined('SQLT_AVC'), 'Constant "SQLT_AVC" missing. Used with oci_bind_array_by_name() to bind arrays of VARCHAR2.');
assert(defined('SQLT_BDOUBLE'), 'Constant "SQLT_BDOUBLE" missing. Not supported.');
assert(defined('SQLT_BFILEE'), 'Constant "SQLT_BFILEE" missing. The same as OCI_B_BFILE.');
assert(defined('SQLT_BFLOAT'), 'Constant "SQLT_BFLOAT" missing. Not supported.');
assert(defined('SQLT_BIN'), 'Constant "SQLT_BIN" missing. The same as OCI_B_BIN.');
assert(defined('SQLT_BLOB'), 'Constant "SQLT_BLOB" missing. The same as OCI_B_BLOB.');
assert(defined('SQLT_CFILEE'), 'Constant "SQLT_CFILEE" missing. The same as OCI_B_CFILEE.');
assert(defined('SQLT_CHR'), 'Constant "SQLT_CHR" missing. Used with oci_bind_array_by_name() to bind arrays of VARCHAR2. Also used with oci_bind_by_name().');
assert(defined('SQLT_CLOB'), 'Constant "SQLT_CLOB" missing. The same as OCI_B_CLOB.');
assert(defined('SQLT_FLT'), 'Constant "SQLT_FLT" missing. Used with oci_bind_array_by_name() to bind arrays of FLOAT.');
assert(defined('SQLT_INT'), 'Constant "SQLT_INT" missing. The same as OCI_B_INT.');
assert(defined('SQLT_LBI'), 'Constant "SQLT_LBI" missing. Used with oci_bind_by_name() to bind LONG RAW values.');
assert(defined('SQLT_LNG'), 'Constant "SQLT_LNG" missing. Used with oci_bind_by_name() to bind LONG values.');
assert(defined('SQLT_LVC'), 'Constant "SQLT_LVC" missing. Used with oci_bind_array_by_name() to bind arrays of LONG VARCHAR.');
assert(defined('SQLT_NTY'), 'Constant "SQLT_NTY" missing. The same as OCI_B_NTY.');
assert(defined('SQLT_NUM'), 'Constant "SQLT_NUM" missing. The same as OCI_B_NUM.');
assert(defined('SQLT_ODT'), 'Constant "SQLT_ODT" missing. Used with oci_bind_array_by_name() to bind arrays of LONG.');
assert(defined('SQLT_RDD'), 'Constant "SQLT_RDD" missing. The same as OCI_B_ROWID.');
assert(defined('SQLT_RSET'), 'Constant "SQLT_RSET" missing. The same as OCI_B_CURSOR.');
assert(defined('SQLT_STR'), 'Constant "SQLT_STR" missing. Used with oci_bind_array_by_name() to bind arrays of STRING.');
assert(defined('SQLT_UIN'), 'Constant "SQLT_UIN" missing. Not supported.');
assert(defined('SQLT_VCS'), 'Constant "SQLT_VCS" missing. Used with oci_bind_array_by_name() to bind arrays of VARCHAR.');
assert(defined('OCI_DTYPE_FILE'), 'Constant "OCI_DTYPE_FILE" missing. This flag tells oci_new_descriptor() to initialize a new FILE descriptor.');
assert(defined('OCI_DTYPE_LOB'), 'Constant "OCI_DTYPE_LOB" missing. This flag tells oci_new_descriptor() to initialize a new LOB descriptor.');
assert(defined('OCI_DTYPE_ROWID'), 'Constant "OCI_DTYPE_ROWID" missing. This flag tells oci_new_descriptor() to initialize a new ROWID descriptor.');
assert(defined('OCI_D_FILE'), 'Constant "OCI_D_FILE" missing. The same as OCI_DTYPE_FILE.');
assert(defined('OCI_D_LOB'), 'Constant "OCI_D_LOB" missing. The same as OCI_DTYPE_LOB.');
assert(defined('OCI_D_ROWID'), 'Constant "OCI_D_ROWID" missing. The same as OCI_DTYPE_ROWID.');

if ($GLOBALS['failed-count'] > 0) {
    exit(1);
}
echo "Pass\n";



//////////////////////////////////////////////////////////////////////////////
// Test defined functons
//////////////////////////////////////////////////////////////////////////////

echo str_pad("Testing defined functions... ", $pad_len);

assert(function_exists('oci_bind_array_by_name'), 'Function "oci_bind_array_by_name" missing. Binds a PHP array to an Oracle PL/SQL array parameter');
assert(function_exists('oci_bind_by_name'), 'Function "oci_bind_by_name" missing. Binds a PHP variable to an Oracle placeholder');
assert(function_exists('oci_cancel'), 'Function "oci_cancel" missing. Cancels reading from cursor');
assert(function_exists('oci_client_version'), 'Function "oci_client_version" missing. Returns the Oracle client library version');
assert(function_exists('oci_close'), 'Function "oci_close" missing. Closes an Oracle connection');
assert(function_exists('oci_commit'), 'Function "oci_commit" missing. Commits the outstanding database transaction');
assert(function_exists('oci_connect'), 'Function "oci_connect" missing. Connect to an Oracle database');
assert(function_exists('oci_define_by_name'), 'Function "oci_define_by_name" missing. Associates a PHP variable with a column for query fetches');
assert(function_exists('oci_error'), 'Function "oci_error" missing. Returns the last error found');
assert(function_exists('oci_execute'), 'Function "oci_execute" missing. Executes a statement');
assert(function_exists('oci_fetch_all'), 'Function "oci_fetch_all" missing. Fetches multiple rows from a query into a two-dimensional array');
assert(function_exists('oci_fetch_array'), 'Function "oci_fetch_array" missing. Returns the next row from a query as an associative or numeric array');
assert(function_exists('oci_fetch_assoc'), 'Function "oci_fetch_assoc" missing. Returns the next row from a query as an associative array');
assert(function_exists('oci_fetch_object'), 'Function "oci_fetch_object" missing. Returns the next row from a query as an object');
assert(function_exists('oci_fetch_row'), 'Function "oci_fetch_row" missing. Returns the next row from a query as a numeric array');
assert(function_exists('oci_fetch'), 'Function "oci_fetch" missing. Fetches the next row from a query into internal buffers');
assert(function_exists('oci_field_is_null'), 'Function "oci_field_is_null" missing. Checks if a field in the currently fetched row is NULL');
assert(function_exists('oci_field_name'), 'Function "oci_field_name" missing. Returns the name of a field from the statement');
assert(function_exists('oci_field_precision'), 'Function "oci_field_precision" missing. Tell the precision of a field');
assert(function_exists('oci_field_scale'), 'Function "oci_field_scale" missing. Tell the scale of the field');
assert(function_exists('oci_field_size'), 'Function "oci_field_size" missing. Returns field\'s size');
assert(function_exists('oci_field_type_raw'), 'Function "oci_field_type_raw" missing. Tell the raw Oracle data type of the field');
assert(function_exists('oci_field_type'), 'Function "oci_field_type" missing. Returns a field\'s data type name');
assert(function_exists('oci_free_descriptor'), 'Function "oci_free_descriptor" missing. Frees a descriptor');
assert(function_exists('oci_free_statement'), 'Function "oci_free_statement" missing. Frees all resources associated with statement or cursor');
assert(function_exists('oci_get_implicit_resultset'), 'Function "oci_get_implicit_resultset" missing. Returns the next child statement resource from a parent statement resource that has Oracle Database 12c Implicit Result Sets');
assert(function_exists('oci_internal_debug'), 'Function "oci_internal_debug" missing. Enables or disables internal debug output');
assert(function_exists('oci_lob_copy'), 'Function "oci_lob_copy" missing. Copies large object');
assert(function_exists('oci_lob_is_equal'), 'Function "oci_lob_is_equal" missing. Compares two LOB/FILE locators for equality');
assert(function_exists('oci_new_collection'), 'Function "oci_new_collection" missing. Allocates new collection object');
assert(function_exists('oci_new_connect'), 'Function "oci_new_connect" missing. Connect to the Oracle server using a unique connection');
assert(function_exists('oci_new_cursor'), 'Function "oci_new_cursor" missing. Allocates and returns a new cursor (statement handle)');
assert(function_exists('oci_new_descriptor'), 'Function "oci_new_descriptor" missing. Initializes a new empty LOB or FILE descriptor');
assert(function_exists('oci_num_fields'), 'Function "oci_num_fields" missing. Returns the number of result columns in a statement');
assert(function_exists('oci_num_rows'), 'Function "oci_num_rows" missing. Returns number of rows affected during statement execution');
assert(function_exists('oci_parse'), 'Function "oci_parse" missing. Prepares an Oracle statement for execution');
assert(function_exists('oci_password_change'), 'Function "oci_password_change" missing. Changes password of Oracle\'s user');
assert(function_exists('oci_pconnect'), 'Function "oci_pconnect" missing. Connect to an Oracle database using a persistent connection');
assert(function_exists('oci_result'), 'Function "oci_result" missing. Returns field\'s value from the fetched row');
assert(function_exists('oci_rollback'), 'Function "oci_rollback" missing. Rolls back the outstanding database transaction');
assert(function_exists('oci_server_version'), 'Function "oci_server_version" missing. Returns the Oracle Database version');
assert(function_exists('oci_set_action'), 'Function "oci_set_action" missing. Sets the action name');
assert(function_exists('oci_set_client_identifier'), 'Function "oci_set_client_identifier" missing. Sets the client identifier');
assert(function_exists('oci_set_client_info'), 'Function "oci_set_client_info" missing. Sets the client information');
assert(function_exists('oci_set_edition'), 'Function "oci_set_edition" missing. Sets the database edition');
assert(function_exists('oci_set_module_name'), 'Function "oci_set_module_name" missing. Sets the module name');
assert(function_exists('oci_set_prefetch'), 'Function "oci_set_prefetch" missing. Sets number of rows to be prefetched by queries');
assert(function_exists('oci_statement_type'), 'Function "oci_statement_type" missing. Returns the type of a statement');

if ($GLOBALS['failed-count'] > 0) {
    exit(1);
}
echo "Pass\n";

//////////////////////////////////////////////////////////////////////////////
// OCI8 Collection functionality
//////////////////////////////////////////////////////////////////////////////

echo str_pad("Class 'OCI-Collection' exists... ", $pad_len);

$class = 'OCI-Collection';
assert(class_exists($class), 'OCI8 Collection functionality');

if ($GLOBALS['failed-count'] > 0) {
    exit(1);
}
echo "Pass\n";

//////////////////////////////////////////////////////////////////////////////
// OCI8 LOB functionality for large binary (BLOB) and character (CLOB) objects
//////////////////////////////////////////////////////////////////////////////

echo str_pad("Class 'OCI-Lob' exists... ", $pad_len);

$class = 'OCI-Lob';
assert(class_exists($class), 'OCI8 LOB functionality for large binary (BLOB) and character (CLOB) objects');

if ($GLOBALS['failed-count'] > 0) {
    exit(1);
}
echo "Pass\n";
