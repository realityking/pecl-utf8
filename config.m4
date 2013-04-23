PHP_ARG_ENABLE(utf8, whether to enable utf8 functions,
[  --enable-utf8         Enable utf8 support])

if test "$PHP_UTF8" != "no"; then
  export OLD_CPPFLAGS="$CPPFLAGS"
  export CPPFLAGS="$CPPFLAGS $INCLUDES -DHAVE_UTF8"

  AC_MSG_CHECKING(PHP version)
  AC_TRY_COMPILE([#include <php_version.h>], [
#if PHP_VERSION_ID < 5300
#error  this extension requires at least PHP version 5.3.0
#endif
],
[AC_MSG_RESULT(ok)],
[AC_MSG_ERROR([need at least PHP 5.3.0])])

  export CPPFLAGS="$OLD_CPPFLAGS"


  PHP_SUBST(UTF8_SHARED_LIBADD)
  AC_DEFINE(HAVE_UTF8, 1, [ ])

  PHP_NEW_EXTENSION(utf8, utf8.c lib/utf8tools.c, $ext_shared)

fi

