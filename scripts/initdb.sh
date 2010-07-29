#!/bin/bash

# UPDATE THIS FIELD IF YOU WANT USE ANOTHER DATABASE NAME
#
# NOTE: if you change this value, update also config/databases.yml
#
DBNAME=asterisell3

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
echo "Enter the MySQL administrator user, to procedee (something like root/admin): "
read -e ADMIN

cd ..
echo "Drop $DBNAME database."
mysqladmin -u $ADMIN -p drop $DBNAME

echo "Create $DBNAME database."
mysqladmin -u $ADMIN -p create $DBNAME
mysql -u $ADMIN -p $DBNAME < data/sql/lib.model.schema.sql

echo "Resetting symfony environment"
sh configure.sh

cd scripts
echo "Initializing database content with some demo data."
php reset_db_and_init_data.php demo root



else
  echo "Execute inside scripts directory."
fi
