#!/bin/bash

#
# Upgrade a 3.x database to the last version.
# 

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then

echo "This script convert a 3.x Asterisell database to its last version."
echo "Data will be not lost."
echo "!!WARNING!!: During upgrading the involved MySQL tables will be locked, and they can not be written."
echo "             This is a fast operation in case of all tables, except CDR table containing all made calls."
echo "             So if you upgrade the same database where Asterisell is running, some calls will be not inserted inside CDR table during this operation."
echo "             In case of CDR tables with 1 milion of records, this operation can require also 1-2 hours."
echo "             Usually in the AsteriSell website there are information about the upgrade, and you will informed if it involves the CDR table."
echo "             When it does not involve the CDR table, you can apply it freely because it is a very fast process."
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

else
  echo "Execute inside scripts directory."
fi
