#!/bin/bash

#
# Upgrade a 3.x database to the last version.
# 

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then

echo "This script convert a 3.x Asterisell database to its last version."
echo "Data will be not lost."
echo " "
echo "Press Ctrl-C to exit."
echo "Enter the name of MySQL database containing Asterisell data."
read DBNAME
echo "Enter the MySQL administrator user, to procedee (something like root/admin): "
read ADMIN
echo "Enter MySQL $ADMIN password:"

read PASSWORD

while read line   
do   
    echo " "
    echo "Execute: $line"
    echo $line | mysql -u $ADMIN --password=$PASSWORD $DBNAME
done <upgrade_db.sql

cd ..
./configure.sh

cd scripts

echo "  "
echo "!!! NOTE: error messages on already upgraded fields are normal/expected. !!!"
echo "  "
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
echo "!!! VAT% IN PARAMS SECTION MUST BE UPDATED TO THE CORRECT VALUE !!!"
echo "!!! NEW FIELDS OF PARAMS SECTION MUST BE COMPLETED.             !!!"
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"

else
  echo "Execute inside scripts directory."
fi
