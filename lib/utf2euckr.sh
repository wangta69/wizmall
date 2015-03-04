find . -type f -name "*.html" -or -name "*.htm" -or -name "*.php" -or -name "*.inc" -or -name "*.db" -or -name "*.css" -or -name "*.js" | while read srcfile; do
cp ${srcfile} ${srcfile}.bak
iconv -c -f utf-8 -t euc-kr ${srcfile}.bak > ${srcfile}
rm ${srcfile}.bak
done
