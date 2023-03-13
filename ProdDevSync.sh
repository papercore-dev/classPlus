if [ ! -d "../temp" ]; then
    mkdir ../temp
    echo "임시 폴더가 없어서 생성했어요."
    fi

cd test

mv .well-known ../temp
mv config ../temp

cd ..

rm -r test
cp -r public test

cd test

rm -r .well-known
rm -r config

rm -r .well-known
rm -r config
mkdir .well-known
mv ../temp/assetlinks.json ./.well-known/assetslinks.json
mv ../temp/config .

cd ..

rm -r temp
echo "완료했어요."