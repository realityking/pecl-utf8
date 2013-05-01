/*
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,       |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt.                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Rouven Weßling <me@rouvenwessling.de>                      |
   +----------------------------------------------------------------------+
*/

#ifndef PHP_UTF8_H
#define PHP_UTF8_H

#ifdef  __cplusplus
extern "C" {
#endif

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <php.h>

#ifdef HAVE_UTF8
#define PHP_UTF8_VERSION "0.0.1dev"


#include <php_ini.h>
#include <SAPI.h>
#include <ext/standard/info.h>
#include <Zend/zend_extensions.h>
#ifdef  __cplusplus
} // extern "C"
#endif
#ifdef  __cplusplus
extern "C" {
#endif

extern zend_module_entry utf8_module_entry;
#define phpext_utf8_ptr &utf8_module_entry

#ifdef PHP_WIN32
#define PHP_UTF8_API __declspec(dllexport)
#else
#define PHP_UTF8_API
#endif

PHP_MINIT_FUNCTION(utf8);
PHP_MSHUTDOWN_FUNCTION(utf8);
PHP_RINIT_FUNCTION(utf8);
PHP_RSHUTDOWN_FUNCTION(utf8);
PHP_MINFO_FUNCTION(utf8);

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_FUNCTION(utf8_is_valid);
ZEND_BEGIN_ARG_INFO_EX(utf8_is_valid_arg_info, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
  ZEND_ARG_INFO(0, str)
ZEND_END_ARG_INFO()

PHP_FUNCTION(utf8_strlen);
ZEND_BEGIN_ARG_INFO_EX(utf8_strlen_arg_info, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
  ZEND_ARG_INFO(0, str)
ZEND_END_ARG_INFO()

PHP_FUNCTION(utf8_substr);
ZEND_BEGIN_ARG_INFO_EX(utf8_substr_arg_info, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
  ZEND_ARG_INFO(0, str)
  ZEND_ARG_INFO(0, start)
  ZEND_ARG_INFO(0, len)
ZEND_END_ARG_INFO()

PHP_FUNCTION(utf8_ord);
ZEND_BEGIN_ARG_INFO_EX(utf8_ord_arg_info, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
  ZEND_ARG_INFO(0, str)
ZEND_END_ARG_INFO()

PHP_FUNCTION(utf8_has_bom);
ZEND_BEGIN_ARG_INFO_EX(utf8_has_bom_arg_info, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
  ZEND_ARG_INFO(0, str)
ZEND_END_ARG_INFO()

#ifdef  __cplusplus
} // extern "C"
#endif

#endif /* PHP_HAVE_UTF8 */

#endif /* PHP_UTF8_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
