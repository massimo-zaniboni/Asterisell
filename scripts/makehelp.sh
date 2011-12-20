#!/bin/bash

#
# Compile and put the help/manual in the web directory
#

BASE=`basename $PWD`

if [ "$BASE" = "scripts" ]; then
  cd ../doc/src
  make latexpdf
  sphinx-build -b html -d doctrees . ../../web/help
  rm ../../web/help/.buildinfo
  cp _build/latex/Asterisell.pdf ../../web/help/.
else
  echo "Execute inside scripts directory."
fi

