#!/bin/bash
#
# Display source code lines with XXX messages 
#

dir=`pwd`
if [ `basename $dir` != "scripts" ]
then
    echo "Run the script inside scripts directory."
    exit -1
fi

cd ..
for dir in apps config
do
  find $dir -name '*.php' -print | xargs grep " XXX " 
  find $dir -name '*.yml' -print | xargs grep " XXX " 
done

exit 0

