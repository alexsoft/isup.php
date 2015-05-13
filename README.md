# ISUP on PHP

Simple website status checker based on [isitup.org](http://isitup.org) and written in PHP.

Installation:

    composer global require "alexsoft/isup"


After that, you can use it as command line tool:

    $ isup google.com
    It's just you. google.com is up.

You can also check multiple domains:

    $ isup google.com github.com vk.com
    It's just you. google.com is up.
    It's just you. github.com is up.
    It's not just you! vk.com looks down from here.