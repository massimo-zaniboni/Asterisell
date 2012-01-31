#!/bin/bash

#
# Build a DB starting from Symfony Schema.
# This script is for developers.
#

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then
  cd ..
  ./symfony propel-build-model
  ./symfony propel-build-sql

  # For supporting recent versions of MySQL
  sed -i -e 's/Type=/Engine=/g' data/sql/lib.model.schema.sql

else
  echo "Execute inside scripts directory."
fi
