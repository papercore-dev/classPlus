const express = require('express')
const Timetable = require('comcigan-parser');
const timetable = new Timetable();
const app = express()
const port = 8271

app.get('/', (req, res) => {
  res.send('Class+ API')
})


//use Comcigan-parser to get timetable from specific school written in parameter
app.get('/timetable/:school/:eduLocation/:grade/:class', (req, res) => {
    try{
        const test = async () => {
            await timetable.init();
            // 학교 검색 및 특정 학교 찾기
            const schoolList = await timetable.search(req.params.school);
            console.log(schoolList);
            const targetSchool = schoolList.find((school) => {
              return school.region === req.params.eduLocation && school.name === req.params.school;
            });
          
            // 학교 설정
            await timetable.setSchool(targetSchool.code);
            const result = await timetable.getTimetable();
          
            // result[학년][반][요일][교시]
            // 요일: (월: 0 ~ 금: 4)
            // 교시: 1교시(0), 2교시(1), 3교시(2)..
            // 2학년 4반 화요일 3교시 시간표
            res.send(result[req.params.grade][req.params.class]);
          
          };
test();
}
catch(err){
    res.send(err);
}
})

//use Comcigan-parser to get timetable from specific school written in parameter
app.get('/classtime/:school/:eduLocation/:grade/:class', (req, res) => {
    try{
        const test = async () => {
            await timetable.init();
            // 학교 검색 및 특정 학교 찾기
            const schoolList = await timetable.search(req.params.school);
            console.log(schoolList);
            const targetSchool = schoolList.find((school) => {
              return school.region === req.params.eduLocation && school.name === req.params.school;
            });
          
            // 학교 설정
            await timetable.setSchool(targetSchool.code);
            res.send(await timetable.getClassTime());
          };
test();
}
catch(err){
    res.send(err);
}
})

app.listen(port, () => {
  console.log(`Class+ API started on port ${port}`)
})