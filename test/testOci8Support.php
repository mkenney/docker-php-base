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

assert(defined('OCI_ASSOC'), 'Used with oci_fetch_all() and oci_fetch_array() to get results as an associative array.');
assert(defined('OCI_BOTH'), 'Used with oci_fetch_all() and oci_fetch_array() to get results as an array with both associative and number indices.');
assert(defined('OCI_COMMIT_ON_SUCCESS'), 'Statement execution mode for oci_execute() call. Automatically commit changes when the statement has succeeded.');
assert(defined('OCI_CRED_EXT'), 'Used with oci_connect() for using Oracles\' External or OS authentication. Introduced in PHP 5.3 and PECL OCI8 1.3.4.');
assert(defined('OCI_DEFAULT'), 'See OCI_NO_AUTO_COMMIT.');
assert(defined('OCI_DESCRIBE_ONLY'), 'Statement execution mode for oci_execute(). Use this mode if you want meta data such as the column names but don\'t want to fetch rows from the query.');
assert(defined('OCI_EXACT_FETCH'), 'Obsolete. Statement fetch mode. Used when the application knows in advance exactly how many rows it will be fetching. This mode turns prefetching off for Oracle release 8 or later mode. The cursor is canceled after the desired rows are fetched which may result in reduced server-side resource usage.');
assert(defined('OCI_FETCHSTATEMENT_BY_COLUMN'), 'Default mode of oci_fetch_all().');
assert(defined('OCI_FETCHSTATEMENT_BY_ROW'), 'Alternative mode of oci_fetch_all().');
assert(defined('OCI_LOB_BUFFER_FREE'), 'Used with OCI-Lob::flush to free buffers used.');
assert(defined('OCI_NO_AUTO_COMMIT'), 'Statement execution mode for oci_execute(). The transaction is not automatically committed when using this mode. For readability in new code, use this value instead of the older, equivalent OCI_DEFAULT constant. Introduced in PHP 5.3.2 (PECL OCI8 1.4).');
assert(defined('OCI_NUM'), 'Used with oci_fetch_all() and oci_fetch_array() to get results as an enumerated array.');
assert(defined('OCI_RETURN_LOBS'), 'Used with oci_fetch_array() to get the data value of the LOB instead of the descriptor.');
assert(defined('OCI_RETURN_NULLS'), 'Used with oci_fetch_array() to get empty array elements if the row items value is NULL.');
assert(defined('OCI_SEEK_CUR'), 'Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SEEK_END'), 'Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SEEK_SET'), 'Used with OCI-Lob::seek to set the seek position.');
assert(defined('OCI_SYSDATE'), 'Obsolete.');
assert(defined('OCI_SYSDBA'), 'Used with oci_connect() to connect with the SYSDBA privilege. The php.ini setting oci8.privileged_connect should be enabled to use this.');
assert(defined('OCI_SYSOPER'), 'Used with oci_connect() to connect with the SYSOPER privilege. The php.ini setting oci8.privileged_connect should be enabled to use this.');
assert(defined('OCI_TEMP_BLOB'), 'Used with OCI-Lob::writeTemporary to indicate that a temporary BLOB should be created.');
assert(defined('OCI_TEMP_CLOB'), 'Used with OCI-Lob::writeTemporary to indicate that a temporary CLOB should be created.');
assert(defined('OCI_B_BFILE'), 'Used with oci_bind_by_name() when binding BFILEs.');
assert(defined('OCI_B_BIN'), 'Used with oci_bind_by_name() to bind RAW values.');
assert(defined('OCI_B_BLOB'), 'Used with oci_bind_by_name() when binding BLOBs.');
assert(defined('OCI_B_CFILEE'), 'Used with oci_bind_by_name() when binding CFILEs.');
assert(defined('OCI_B_CLOB'), 'Used with oci_bind_by_name() when binding CLOBs.');
assert(defined('OCI_B_CURSOR'), 'Used with oci_bind_by_name() when binding cursors, previously allocated with oci_new_descriptor().');
assert(defined('OCI_B_INT'), 'Used with oci_bind_array_by_name() to bind arrays of INTEGER.');
assert(defined('OCI_B_NTY'), 'Used with oci_bind_by_name() when binding named data types. Note: in PHP < 5.0 it was called OCI_B_SQLT_NTY.');
assert(defined('OCI_B_NUM'), 'Used with oci_bind_array_by_name() to bind arrays of NUMBER.');
assert(defined('OCI_B_ROWID'), 'Used with oci_bind_by_name() when binding ROWIDs.');
assert(defined('SQLT_AFC'), 'Used with oci_bind_array_by_name() to bind arrays of CHAR.');
assert(defined('SQLT_AVC'), 'Used with oci_bind_array_by_name() to bind arrays of VARCHAR2.');
assert(defined('SQLT_BDOUBLE'), 'Not supported.');
assert(defined('SQLT_BFILEE'), 'The same as OCI_B_BFILE.');
assert(defined('SQLT_BFLOAT'), 'Not supported.');
assert(defined('SQLT_BIN'), 'The same as OCI_B_BIN.');
assert(defined('SQLT_BLOB'), 'The same as OCI_B_BLOB.');
assert(defined('SQLT_CFILEE'), 'The same as OCI_B_CFILEE.');
assert(defined('SQLT_CHR'), 'Used with oci_bind_array_by_name() to bind arrays of VARCHAR2. Also used with oci_bind_by_name().');
assert(defined('SQLT_CLOB'), 'The same as OCI_B_CLOB.');
assert(defined('SQLT_FLT'), 'Used with oci_bind_array_by_name() to bind arrays of FLOAT.');
assert(defined('SQLT_INT'), 'The same as OCI_B_INT.');
assert(defined('SQLT_LBI'), 'Used with oci_bind_by_name() to bind LONG RAW values.');
assert(defined('SQLT_LNG'), 'Used with oci_bind_by_name() to bind LONG values.');
assert(defined('SQLT_LVC'), 'Used with oci_bind_array_by_name() to bind arrays of LONG VARCHAR.');
assert(defined('SQLT_NTY'), 'The same as OCI_B_NTY.');
assert(defined('SQLT_NUM'), 'The same as OCI_B_NUM.');
assert(defined('SQLT_ODT'), 'Used with oci_bind_array_by_name() to bind arrays of LONG.');
assert(defined('SQLT_RDD'), 'The same as OCI_B_ROWID.');
assert(defined('SQLT_RSET'), 'The same as OCI_B_CURSOR.');
assert(defined('SQLT_STR'), 'Used with oci_bind_array_by_name() to bind arrays of STRING.');
assert(defined('SQLT_UIN'), 'Not supported.');
assert(defined('SQLT_VCS'), 'Used with oci_bind_array_by_name() to bind arrays of VARCHAR.');
assert(defined('OCI_DTYPE_FILE'), 'This flag tells oci_new_descriptor() to initialize a new FILE descriptor.');
assert(defined('OCI_DTYPE_LOB'), 'This flag tells oci_new_descriptor() to initialize a new LOB descriptor.');
assert(defined('OCI_DTYPE_ROWID'), 'This flag tells oci_new_descriptor() to initialize a new ROWID descriptor.');
assert(defined('OCI_D_FILE'), 'The same as OCI_DTYPE_FILE.');
assert(defined('OCI_D_LOB'), 'The same as OCI_DTYPE_LOB.');
assert(defined('OCI_D_ROWID'), 'The same as OCI_DTYPE_ROWID.');

if ($GLOBALS['failed-count'] > 0) {
    exit(1);
}
echo "Pass\n";



//////////////////////////////////////////////////////////////////////////////
// Test defined functons
//////////////////////////////////////////////////////////////////////////////

echo str_pad("Testing defined functions... ", $pad_len);

assert(function_exists('oci_bind_array_by_name'), 'Binds a PHP array to an Oracle PL/SQL array parameter');
assert(function_exists('oci_bind_by_name'), 'Binds a PHP variable to an Oracle placeholder');
assert(function_exists('oci_cancel'), 'Cancels reading from cursor');
assert(function_exists('oci_client_version'), 'Returns the Oracle client library version');
assert(function_exists('oci_close'), 'Closes an Oracle connection');
assert(function_exists('oci_commit'), 'Commits the outstanding database transaction');
assert(function_exists('oci_connect'), 'Connect to an Oracle database');
assert(function_exists('oci_define_by_name'), 'Associates a PHP variable with a column for query fetches');
assert(function_exists('oci_error'), 'Returns the last error found');
assert(function_exists('oci_execute'), 'Executes a statement');
assert(function_exists('oci_fetch_all'), 'Fetches multiple rows from a query into a two-dimensional array');
assert(function_exists('oci_fetch_array'), 'Returns the next row from a query as an associative or numeric array');
assert(function_exists('oci_fetch_assoc'), 'Returns the next row from a query as an associative array');
assert(function_exists('oci_fetch_object'), 'Returns the next row from a query as an object');
assert(function_exists('oci_fetch_row'), 'Returns the next row from a query as a numeric array');
assert(function_exists('oci_fetch'), 'Fetches the next row from a query into internal buffers');
assert(function_exists('oci_field_is_null'), 'Checks if a field in the currently fetched row is NULL');
assert(function_exists('oci_field_name'), 'Returns the name of a field from the statement');
assert(function_exists('oci_field_precision'), 'Tell the precision of a field');
assert(function_exists('oci_field_scale'), 'Tell the scale of the field');
assert(function_exists('oci_field_size'), 'Returns field\'s size');
assert(function_exists('oci_field_type_raw'), 'Tell the raw Oracle data type of the field');
assert(function_exists('oci_field_type'), 'Returns a field\'s data type name');
assert(function_exists('oci_free_descriptor'), 'Frees a descriptor');
assert(function_exists('oci_free_statement'), 'Frees all resources associated with statement or cursor');
assert(function_exists('oci_get_implicit_resultset'), 'Returns the next child statement resource from a parent statement resource that has Oracle Database 12c Implicit Result Sets');
assert(function_exists('oci_internal_debug'), 'Enables or disables internal debug output');
assert(function_exists('oci_lob_copy'), 'Copies large object');
assert(function_exists('oci_lob_is_equal'), 'Compares two LOB/FILE locators for equality');
assert(function_exists('oci_new_collection'), 'Allocates new collection object');
assert(function_exists('oci_new_connect'), 'Connect to the Oracle server using a unique connection');
assert(function_exists('oci_new_cursor'), 'Allocates and returns a new cursor (statement handle)');
assert(function_exists('oci_new_descriptor'), 'Initializes a new empty LOB or FILE descriptor');
assert(function_exists('oci_num_fields'), 'Returns the number of result columns in a statement');
assert(function_exists('oci_num_rows'), 'Returns number of rows affected during statement execution');
assert(function_exists('oci_parse'), 'Prepares an Oracle statement for execution');
assert(function_exists('oci_password_change'), 'Changes password of Oracle\'s user');
assert(function_exists('oci_pconnect'), 'Connect to an Oracle database using a persistent connection');
assert(function_exists('oci_result'), 'Returns field\'s value from the fetched row');
assert(function_exists('oci_rollback'), 'Rolls back the outstanding database transaction');
assert(function_exists('oci_server_version'), 'Returns the Oracle Database version');
assert(function_exists('oci_set_action'), 'Sets the action name');
assert(function_exists('oci_set_client_identifier'), 'Sets the client identifier');
assert(function_exists('oci_set_client_info'), 'Sets the client information');
assert(function_exists('oci_set_edition'), 'Sets the database edition');
assert(function_exists('oci_set_module_name'), 'Sets the module name');
assert(function_exists('oci_set_prefetch'), 'Sets number of rows to be prefetched by queries');
assert(function_exists('oci_statement_type'), 'Returns the type of a statement');

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
