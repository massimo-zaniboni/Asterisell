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
releasedir=$myhome/..
packagename=$dist.tar.gz
releasepackage=$releasedir/$packagename

echo "Save the last committed version of the current branch to $releasepackage"
echo "Change VERSION file content to update the name of package."
echo "Make sure that all important files are added to GIT repository, and that all private files are not included."
echo "Make sure that configuration files are in the expected/public form."
echo "Press enter to continue"
read

git archive --format=tar --prefix=$dist/ HEAD | gzip > $releasepackage

