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

  echo ""
  echo "WARNING: Replace manually occurrences of "
  echo ""
  echo "   'Type=InnoDB;'"
  echo ""
  echo " with "
  echo ""
  echo "   'Engine=InnoDB;'"
  echo ""
  echo "inside 'data/sql/lib.model.schema.sql'"
  echo "for supporting recent versions of MySQL."
    
else
  echo "Execute inside scripts directory."
fi
