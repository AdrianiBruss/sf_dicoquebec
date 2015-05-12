#!/bin/bash
echo "starting wotd script"
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
cd /Applications/MAMP/htdocs/sf_dicoquebec/
php app/console wotd:get
