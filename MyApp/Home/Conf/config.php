<?php
return array(
    //'配置项'=>'配置值'
 'SHOW_PAGE_TRACE' => false,

    /* 数据库连接配置 开始 */
    'DB_TYPE' => 'sqlsrv',   /*数据库类型  */
    'DB_HOST' => '192.168.1.114',   /*服务器地址  */
    'DB_NAME' => 'cmDB',    /*数据库名  */
    'DB_USER' => 'sa',    /*用户名  */
    'DB_PWD' => 's123456', /*密码  */
    'DB_PORT' => 1433,  /*端口  */
    'DB_PARAMS' => array(), /*数据库连接参数 */
    'DB_PREFIX' => '', /*数据库表前缀 */
    'DB_CHARSET' => 'utf8', /*字符集 */


    'TMPL_PARSE_STRING'  =>array(
        '__IMG__' => '/Public/img',
        '__CSS__' => '/Public/css',
        '__JS__' => '/Public/js',
        '__LAYER__' => '/Public/layer',
    ),/*文件目录*/


    'URL_ROUTER_ON' => true, //开启路由
    'URL_MODEL'=>2,

   'DB_DEBUG' => false,
);

?>