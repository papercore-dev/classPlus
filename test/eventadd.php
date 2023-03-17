<?php

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

$headName = "일정 만들기";
include 'ui/menu/menu.custom.html.php';
chdir(dirname(__FILE__));
?>

  <div class="mx-auto w-full">
    <form action="/form/write.php" method="POST">
      <div class="">
        <input
          type="text"
          name="title"
          id="title"
          placeholder="일정 제목"
          class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
    <!--field to enter start date and end date and visibility-->
        <div class="flex flex-row justify-between">
            <div class="w-1/2">
            <input
                type="date"
                name="startDate"
                id="startDate"
                placeholder="시작 날짜"
                class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
            </div>
            <div class="w-1/2">
            <input
                type="date"
                name="endDate"
                id="endDate"
                placeholder="종료 날짜"
                class="w-full border-t border-b bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
            </div>
        </div>

      <div>
        <button
          class="hover:shadow-lg rounded-lg bg-blue-500 py-3 px-8 text-base font-semibold text-white outline-none"
        >
          만들기
        </button>
      </div>
    </form>
  </div>
<?php
include 'ui/common/footer.html.php';
chdir(dirname(__FILE__));
?>
