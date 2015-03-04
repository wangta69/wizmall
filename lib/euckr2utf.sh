find . -type f -name "*.html" -or -name "*.htm" -or -name "*.php" -or -name "*.inc" -or -name "*.db" -or -name "*.css" -or -name "*.js" | while read srcfile; do
cp ${srcfile} ${srcfile}.bak
iconv -c -f euc-kr -t utf-8 ${srcfile}.bak > ${srcfile}
rm ${srcfile}.bak
done
