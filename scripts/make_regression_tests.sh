# Performs separate passes in order to do regression tests
# because all this code in a single file generates
# some error.
#

echo "WARNING: all data will be deleted from the database."

echo -n "                Do you want to proceed (Y/N)?"
read answer
if test "$answer" != "Y" -a "$answer" != "y";
then exit 0;
fi

echo "Clear symfony cache because it can invalidate calculations."
cd ..
./symfony cc

cd scripts

echo "Inserting data"
php insert_regression_data.php

echo "Rating data"
php rate_all_and_test.php

echo "Checking data"
php check_regression_data.php

echo " "
echo "Web user with login \"root\" and password \"root\" is created."
