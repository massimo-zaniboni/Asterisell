#!/bin/bash

#
# Build a DB starting from Symfony Schema.
#

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then
  cd ..
  ./symfony propel-build-model
  ./symfony propel-build-sql
else
  echo "Execute inside scripts directory."
fi

