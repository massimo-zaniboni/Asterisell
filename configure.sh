#!/bin/bash

mkdir -p cache
mkdir -p log
mkdir -p web/generated_graphs

echo "Clear symfony cache, in order to enable new settings."
./symfony cc
./symfony fix-perms

# In this directory the system put 
# generated graphs.
#
chmod ug+rwx web/

echo "Regenerate modules depending from the new cache values."
cd module_templates
php generate.php

cd ..
./symfony cc

