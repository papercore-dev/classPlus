<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/menu.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));
include 'functions/timeToRelative.php';
chdir(dirname(__FILE__));

//ID 검증
if (!isset($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
if (!is_numeric($_GET["id"])){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
} 

$serviceName = $_GET["id"];

$getServiceData = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."' AND boardHidden = '0' AND write_accessLevel <= '".$_SESSION['accessLevel']."'";
$getServiceData_Result = $db->query($getServiceData);
if ($getServiceData_Result->rowCount() == 0){
    echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
    die;
}
else{
    while($row = $getServiceData_Result->fetch()){
        include 'functions/specificFunction.php';
        if ($isBannerHidden){
            echo "<script>window.location.href = '/explore.php?error=게시판이 존재하지 않거나 삭제됐어요.';</script>";
            die;
        }
    }
}

//게시판 이름 구하기
$getServiceName = "SELECT * FROM `posts_board` WHERE boardID = '".$serviceName."'";
$getServiceName_Result = $db->query($getServiceName);
$boardName = "";
while($row = $getServiceName_Result->fetch()){
    $boardName = $row["boardName"];
}

$headName = $boardName." 게시판에 글 쓰기";
include 'ui/menu/menu.custom.html.php';
chdir(dirname(__FILE__));
?>
  <div class="mx-auto w-full">
    <form action="#" method="POST">
      <div class="">
        <input
          type="text"
          name="title"
          id="title"
          placeholder="제목"
          class="w-full border border-gray-500 bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
      <div class="mb-5">
        <textarea
          rows="4"
          name="post"
          id="post"
          placeholder="내용을 작성해주세요"
          class="w-full resize-none border-b border-l border-r border-gray-500 bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        ></textarea>
      </div>
      <div>
        <input type="hidden" name="imageURL" />
        <button
          class="hover:shadow-lg rounded-lg bg-blue-500 py-3 px-8 text-base font-semibold text-white outline-none"
        >
          쓰기
        </button>
      </div>
    </form>
            <!-- image upload form using imgbb -->
            <div class="mb-5">

<p class="text-red-500 mt-4" id="submissionError">
</p>
<input type="file" id="image" hidden style="display:none;" accept="image/*"></input>
<button type="button" id="next-button" class="hover:shadow-lg rounded-lg bg-blue-500 py-3 px-8 text-base font-semibold text-white outline-none" onclick="imgUpload()">이미지 업로드</button>
<script>
function imgUpload() {
image = document.getElementById("image");
image.click();
image.style.display = "block";
document.getElementById("next-button").classList.add("opacity-50");
}
document.getElementById("image").addEventListener("change", function() {
var form = new FormData();
    form.append("image", image.files[0]);
    form.append("key", "f6b9c05f362e92b7be21792346f9243e");
    form.append("name", "post_upload_<?php echo $_GET['id']; ?>");

    var settings = {
    "url": "https://api.imgbb.com/1/upload",
    "method": "POST",
    "timeout": 0,
    "processData": false,
    "mimeType": "multipart/form-data",
    "contentType": false,
    "data": form
    };

    $.ajax(settings).done(function (response) {
        var res = JSON.parse(response);
        if (res.success == true){
            document.getElementById("imageURL").value = res.data.url;
            document.getElementById("next-button").classList.remove("opacity-50");
            document.getElementById("image").style.display = "none";
        }
        else{
            document.getElementById("submissionError").innerHTML = "이미지 업로드에 실패했어요. 다시 시도해주세요.";
        }
    });
});
</script>
</div>
  </div>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
