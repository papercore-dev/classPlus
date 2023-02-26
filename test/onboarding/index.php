<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../ui/common/header.html.php';
chdir(dirname(__FILE__));

include '../functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/onboarding");

//find user from database and check if user accepted EULA later than 2023-02-27
//if user accepted EULA later than 2023-02-27, redirect to /app.php
//if user accepted EULA earlier than 2023-02-27, show onboarding page

$findPrevRecord = "SELECT * FROM `account_users` WHERE `signMethod` = '".$_SESSION['signMethod']."' AND `userID` = '".$_SESSION['userID']."'";
$findPrevRecord_Result = $db->query($findPrevRecord);  
if ($findPrevRecord_Result->rowCount() > 0){
    while($row = $findPrevRecord_Result->fetch()){
        if ($row['eulaAccepted'] !== null){
            $redirectAfterOnboarding = "/app.php";
            if ($row['eulaAccepted'] > 1614396800){
                echo "<script>window.location.href = '/app.php';</script>";
                die;
                }
        }
        else{
            $redirectAfterOnboarding = "/onboarding/kyc.php";
        }
    }
}
?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto">
<div class="h-full bg-white">
<div class="bg-white rounded-b-xl p-5  text-white">
<div class="flex items-center justify-between">
<div class="text-gray-100 ">
</div>
<div class="flex">
</div>
</div>
</div>
<section class="p-5">
<div class="space-y-2">

</div>


<div class="mb-12">
    <div class="mb-12">
<h2 class="mb-4 text-3xl font-bold text-left lg:text-5xl">
학급 생활에
<div id="container" class="text-5xl text-blue-500 leading-relaxeds">
<div id="text" class="inline-block"></div><div id="cursor" class="inline-block animate-pulse" style="display: none;">|</div>
</div>
</h2>
<script type="text/javascript">
                    // List of sentences
var _CONTENT = [ 
	"재미를 플러스",
    "자율성을 플러스",
    "친구를 플러스",
    "편리함을 플러스",
    "즐거움을 플러스"
];

// Current sentence being processed
var _PART = 0;

// Character number of the current sentence being processed 
var _PART_INDEX = 0;

// Holds the handle returned from setInterval
var _INTERVAL_VAL;

// Element that holds the text
var _ELEMENT = document.querySelector("#text");

// Cursor element 
var _CURSOR = document.querySelector("#cursor");

// Implements typing effect
function Type() { 
	// Get substring with 1 characater added
	var text =  _CONTENT[_PART].substring(0, _PART_INDEX + 1);
	_ELEMENT.innerHTML = text;
	_PART_INDEX++;

	// If full sentence has been displayed then start to delete the sentence after some time
	if(text === _CONTENT[_PART]) {
		// Hide the cursor
		_CURSOR.style.display = 'none';

		clearInterval(_INTERVAL_VAL);
		setTimeout(function() {
			_INTERVAL_VAL = setInterval(Delete, 50);
		}, 1000);
	}
}

// Implements deleting effect
function Delete() {
	// Get substring with 1 characater deleted
	var text =  _CONTENT[_PART].substring(0, _PART_INDEX - 1);
	_ELEMENT.innerHTML = text;
	_PART_INDEX--;

	// If sentence has been deleted then start to display the next sentence
	if(text === '') {
		clearInterval(_INTERVAL_VAL);

		// If current sentence was last then display the first one, else move to the next
		if(_PART == (_CONTENT.length - 1))
			_PART = 0;
		else
			_PART++;
		
		_PART_INDEX = 0;

		// Start to display the next sentence after some time
		setTimeout(function() {
			_CURSOR.style.display = 'inline-block';
			_INTERVAL_VAL = setInterval(Type, 100);
		}, 200);
	}
}

// Start the typing effect on load
_INTERVAL_VAL = setInterval(Type, 100);
</script>
<p class="visible mx-0 mt-3 mb-0 text-sm leading-relaxed text-left text-gray-400">
학교와 학급회장이 함께 운영하는 커뮤니티를 넘어,<br>학교생활에 유용한 정보를 제공하는 여기는 클래스+에요.
</p>
</div>
	<div class='flex flex-row my-2'>
		<input type="checkbox" id="cb1" value="cb1"
        class='
            appearance-none h-6 w-6 bg-gray-400 rounded-md 
            checked:bg-blue-500 checked:scale-75
            transition-all duration-200 peer
        '
    />
		<div class='h-6 w-6 absolute rounded-md pointer-events-none
        peer-checked:border-blue-500 peer-checked:border-2
        '>
		</div>
		<label for='cb1' class='flex flex-col justify-center px-2 peer-checked:text-blue-400  select-none'>개인정보 처리방침에 대한 동의 (필수)
        <a href="https://metroplus.notion.site/024e9b4918384709b242ad7807e1bc51" class="font-semibold text-gray-500 hover:underline">보기</a>
        </label>
	</div>
</div>
</section>
<div class="pb-32"></div>

</div>
<div class="fixed bottom-0 left-0 w-full z-10 gradient">
<div class="m-4">

<div class=" justify-center items-center gap-4">
<button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl">계속하기</button>

<script>
    var cb1 = document.getElementById("cb1");
    var btn = document.querySelector("button");
    cb1.addEventListener("change", function() {
        if (cb1.checked) {
            btn.classList.remove("bg-gray-400");
            btn.classList.remove("hover:bg-gray-400");
            btn.classList.add("bg-blue-500");
            btn.classList.add("hover:bg-blue-700");
            btn.onClick = "continueOnboard();";
        } else {
            btn.classList.remove("bg-blue-500");
            btn.classList.remove("hover:bg-blue-700");
            btn.classList.add("bg-gray-400");
            btn.classList.add("hover:bg-gray-400");
            btn.onClick = "console.log('Not checked');";
        }
    });

    function continueOnboard() {
        turbo.visit('acceptEULA.php');
    }
</script>
</div>
</div>
</div>

</div>
</body>
</html>