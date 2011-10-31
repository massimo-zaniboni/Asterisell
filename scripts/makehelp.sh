#!/bin/bash

#
# Build a DB starting from Symfony Schema.
#

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then
  cd ../doc/src
  make html
  make latexpdf
  sphinx-build -b html -d doctrees . ../../web/help
  cp _build/latex/Asterisell.pdf ../../web/help/.
else
  echo "Execute inside scripts directory."
fi

