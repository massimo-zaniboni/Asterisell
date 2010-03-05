cd ..
for file in $(find apps/asterisell -name '*.php' -type f)
do
  echo $file
  php_beautifier -s2 $file -o $file.new
  rm $file
  mv $file.new $file
done
