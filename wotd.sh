#!/bin/bash
echo "starting wotd script"
export PATH=/Applications/MAMP/bin/php/php5.5.3/bin:$PATH
cd /Applications/MAMP/htdocs/Symfony/sf_dicoquebec/
php app/console wotd:get
