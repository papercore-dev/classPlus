if [ ! -d "../temp" ]; then
    mkdir ../temp
    echo "임시 폴더가 없어서 생성했어요."
    fi

cd test

mv .well-known ../temp/.well-known
mv config ../temp/config

cd ..

rm -r test
cp -r public test

cd test

rm -r .well-known
rm -r config

mv ../temp/.well-known .
mv ../temp/config .