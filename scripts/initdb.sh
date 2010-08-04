#!/bin/bash

#
# Load a DB supposing the Symfony Schema is already built.
# 

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then

echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
echo "!!! WARNING: This script will delete all data !!!"
echo "!!! in asterisell3 MySQL database.            !!!"
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
echo " "
echo "Press Ctrl-C to exit."
echo "Enter the name of MySQL database containing Asterisell data."
read DBNAME
echo "Enter the MySQL administrator user, to procedee (something like root/admin): "
read ADMIN
echo "Enter MySQL $ADMIN password:"
read PASSWORD

cd ..
echo "Drop $DBNAME database."
mysqladmin -u $ADMIN --password=$PASSWORD drop $DBNAME

echo "Create $DBNAME database."
mysqladmin -u $ADMIN --password=$PASSWORD create $DBNAME
mysql -u $ADMIN --password=$PASSWORD $DBNAME < data/sql/lib.model.schema.sql

echo "Resetting symfony environment"
sh configure.sh

cd scripts
echo "Initializing database content with some demo data."
php reset_db_and_init_data.php demo root

else
  echo "Execute inside scripts directory."
fi
