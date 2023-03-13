if [ ! -d "../temp" ]; then
    mkdir ../temp
    echo "임시 폴더가 없어서 생성했어요."
    fi

cd public

mv .well-known ../temp
mv config ../temp

cd ..

rm -r public
cp -r test public

cd public

rm -r .well-known
rm -r config

mv ../temp/.well-known .
mv ../temp/config .

cd ..

rm -r temp
echo "완료했어요."