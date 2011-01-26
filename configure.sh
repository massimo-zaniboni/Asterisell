#!/bin/bash

mkdir -p cache
mkdir -p log
mkdir -p web/generated_graphs

echo "Create VERSION"
echo -n "asterisell-" > VERSION
cat VERSION-TYPE >> VERSION
echo -n "-" >> VERSION
cat VERSION-NR >> VERSION
cat VERSION

echo "Clear symfony cache, in order to enable new settings."
./symfony cc
./symfony fix-perms

# In this directory the system put 
# generated graphs.
#
chmod -R ug+rwx web/
chmod -R ug+rx ext_libs/
chmod -R ug+rx apps/

# Remove lock files 
#
rm -f web/*.lock

echo "Regenerate modules depending from the new cache values."
cd module_templates
php generate.php

cd ..
./symfony cc

echo "Generated VERSION "
cat VERSION
echo ""
