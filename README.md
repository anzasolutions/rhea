rhea
====

Yet another PHP MVC framework. Created in 2012.

<img alt="Build Status" src="https://travis-ci.org/anzasolutions/rhea.png">

When running tests in Eclipse (Indigo 3.7.2) with MakeGood (2.3.0) the following must be configured:

- install log4php according to: http://logging.apache.org/log4php/install.html
- add PEAR to PHP Include Path
- go to Project > Properties > MakeGood > General:
  - select "PHPUnit" radio button
  - add test pattern: Test File Pattern: test(?:Case)?\.php$
  - add bootstrap: Preload Script: /rhea/test/bootstrap.php

Requires PHP 5.3+
