#!/bin/bash

dir=`pwd`
if [ `basename $dir` != "scripts" ]
then
    echo "Run the script inside scripts directory."
    exit -1
fi

cd ..
myhome=`pwd`
dist=`cat VERSION | head --lines=1`
releasebasedir=$myhome/../website/releases
releasedir=$releasebasedir/$dist
packagename=$dist.tar.gz
releasepackage=$releasebasedir/$packagename

echo "This script will create a release according name in VERSION file."
echo "Make sure that \"$dist\" is the correct name of this version."
echo "The resulting package will be put in \"$releasepackage\""
echo "The uncompressed content of the package will be in \"$releasedir\""
echo "Files are copied according content of \"$myhome/scripts/dist_files.list\""
read

echo "The content of temp_dev is removed from distribution."
echo "The current apps/asterisell/config/app.yml will be removed and only apps/asterisell/config/_app.yml will remain. Make dure that the content of this file is correct."
echo "The current config/databases.yml will be removed and only config/_databases.yml will remain."
echo "The current config/propel.ini will be removed and only config/_propel.ini will remain."
echo "Are your sure that all these configuration files are updated?"
read

echo "Update website documentation"
cd doc/htmlgenerator
rake gen

cd $myhome

echo "Symfony maintanance"
symfony cc
symfony fix-perms

echo "Copying files to \"$releasedir\""
mkdir -p $releasedir
rm -r -f $releasedir
mkdir -p $releasedir


# NOTE: this selective copy allows to exlude from the beginning .hg 
# and similar directories...
#
while read file; do
    echo "Copying $file to $releasedir"
    cp -r $file $releasedir/.
done <scripts/dist_files.list

cd $releasedir

echo "Remove non necessary files from \"$releasedir\""
find . -name '*~' -print | xargs rm -f
find . -name 'semantic.cache' -print | xargs rm -f
rm -r -f log/*

echo "Disable \"dev\" and \"test\" environments and enable \"prod\" environment."

symfony cc
symfony fix-perms
symfony enable asterisell prod
symfony disable asterisell dev
symfony disable asterisell test

echo "Replace with default configuration files."

# remove in order to not overwrite already installed
# configuration file of the user in case of upgrade
#
rm apps/asterisell/config/app.yml
rm config/databases.yml
rm config/propel.ini

echo "Creating $releasepackage"
tar cfz $releasepackage --directory $releasebasedir $dist

echo "IMPORTANT: check if SORT ON COST patch is applied to Symfony framework."

exit 0
