<?php
/**** 첫번째 ***************/
## 현재 저장된 모들 파일을 불러온다.
$STRING="<?
\#\# config1
\$cfg[\"wizboard\"][\"SameDB\"]						=\"$SameDB\";
\$cfg[\"wizboard\"][\"ExtendDB\"]					=\"$ExtendDB\";
\$cfg[\"wizboard\"][\"ExtendDBUse\"]				=\"$ExtendDBUse\";
\$cfg[\"wizboard\"][\"ICON_SKIN_TYPE\"]				=\"$ICON_SKIN_TYPE\";
\$cfg[\"wizboard\"][\"BOARD_SKIN_TYPE\"]			=\"$BOARD_SKIN_TYPE\";
\$cfg[\"wizboard\"][\"BOTTOM_SKIN_TYPE\"]			=\"$BOTTOM_SKIN_TYPE\";
\$cfg[\"wizboard\"][\"REPLE_SKIN_TYPE\"]			=\"$REPLE_SKIN_TYPE\";
\$cfg[\"wizboard\"][\"INCLUDE_MALL_SKIN\"]			=\"$INCLUDE_MALL_SKIN\";
\$cfg[\"wizboard\"][\"TABLE_WIDTH\"]				=\"${TABLE_WIDTH}\";
\$cfg[\"wizboard\"][\"TABLE_WIDTH_UNIT\"]			=\"${TABLE_WIDTH_UNIT}\";
\$cfg[\"wizboard\"][\"TABLE_ALIGN\"]				=\"$TABLE_ALIGN\";
\$cfg[\"wizboard\"][\"AdminOnly\"]					=\"$AdminOnly\";
\$cfg[\"wizboard\"][\"SecretBoard\"]				=\"$SecretBoard\";
\$cfg[\"wizboard\"][\"setsecurityiframe\"]				=\"$setsecurityiframe\";
\$cfg[\"wizboard\"][\"setsecurityscript\"]				=\"$setsecurityscript\";
\$cfg[\"wizboard\"][\"qnaboard\"]					=\"$qnaboard\";
\$cfg[\"wizboard\"][\"INCLUDE_MALL_SKIN\"]			=\"$INCLUDE_MALL_SKIN\";\#\#큰 레이아웃으로 쇼핑몰 적용
\$cfg[\"wizboard\"][\"topcomment\"]					=\"$topcomment\";\#\#리스트 페이지 상단에 금주 추천게시물 디스플레이(스킨별별도적용)
\$cfg[\"wizboard\"][\"ATTACHEDCOUNT\"]				=\"$ATTACHEDCOUNT\";
\$cfg[\"wizboard\"][\"UpLoadingOverWriteEnable\"]	= \"$UpLoadingOverWriteEnable\";
\$cfg[\"wizboard\"][\"editorenable\"]				=\"$editorenable\";

\#\# config2
\$cfg[\"wizboard\"][\"AdminAlign\"]					=\"$AdminAlign\";
\$cfg[\"wizboard\"][\"SubjectLength\"]				=\"$SubjectLength\";
\$cfg[\"wizboard\"][\"NameLength\"]					=\"$NameLength\";
\$cfg[\"wizboard\"][\"ListNo\"]						=\"$ListNo\";
\$cfg[\"wizboard\"][\"PageNo\"]						=\"$PageNo\";
\$cfg[\"wizboard\"][\"NewTime\"]					=\"$NewTime\";
\$cfg[\"wizboard\"][\"Bgcolort\"]					=\"$Bgcolort\";
\$cfg[\"wizboard\"][\"Bgcolorl\"]					=\"$Bgcolorl\";
\$cfg[\"wizboard\"][\"Bgcolors\"]					=\"$Bgcolors\";
\$cfg[\"wizboard\"][\"Bgcolorp\"]					=\"$Bgcolorp\";
\$cfg[\"wizboard\"][\"Linecolor\"]					=\"$Linecolor\";
\$cfg[\"wizboard\"][\"Fontcolort\"]					=\"$Fontcolort\";
\$cfg[\"wizboard\"][\"Fontcolorl\"]					=\"$Fontcolorl\";
\$cfg[\"wizboard\"][\"fontcolors\"]					=\"$fontcolors\";

\#\# config3
\$cfg[\"wizboard\"][\"VSubjectLength\"]				=\"$VSubjectLength\";
\$cfg[\"wizboard\"][\"VNameLength\"]				=\"$VNameLength\";
\$cfg[\"wizboard\"][\"ReplyBtn\"]					=\"$ReplyBtn\";
\$cfg[\"wizboard\"][\"AutoLink\"]					=\"$AutoLink\";
\$cfg[\"wizboard\"][\"CommentEnable\"]				=\"$CommentEnable\";
\$cfg[\"wizboard\"][\"ListEnable\"]					=\"$ListEnable\";
\$cfg[\"wizboard\"][\"Bgcolort\"]					=\"$Bgcolort\";
\$cfg[\"wizboard\"][\"Bgcolorl\"]					=\"$Bgcolorl\";
\$cfg[\"wizboard\"][\"Bgcolor3\"]					=\"$Bgcolor3\";
\$cfg[\"wizboard\"][\"Bgcolor4\"]					=\"$Bgcolor4\";
\$cfg[\"wizboard\"][\"Bgcolors\"]					=\"$Bgcolors\";
\$cfg[\"wizboard\"][\"Linecolor\"]					=\"$Linecolor\";
\$cfg[\"wizboard\"][\"Fontcolort\"]					=\"$Fontcolort\";
\$cfg[\"wizboard\"][\"Fontcolorl\"]					=\"$Fontcolorl\";
\$cfg[\"wizboard\"][\"Fontcolors\"]					=\"$Fontcolors\";
\$cfg[\"wizboard\"][\"Fontcolors4\"]				=\"$Fontcolors4\";
\#\# config4
\$cfg[\"wizboard\"][\"wBgcolort\"]					=\"$wBgcolort\";
\$cfg[\"wizboard\"][\"wBgcolorl\"]					=\"$wBgcolorl\";
\$cfg[\"wizboard\"][\"wBgcolors\"]					=\"$wBgcolors\";
\$cfg[\"wizboard\"][\"wLinecolor\"]					=\"$wLinecolor\";
\$cfg[\"wizboard\"][\"wFontcolort\"]					=\"$wFontcolort\";
\$cfg[\"wizboard\"][\"Write_prohibition_Word\"]					=\"$Write_prohibition_Word\";

\#\# config5
\$cfg[\"wizboard\"][\"ListForMember\"]				=\"$ListForMember\";
\$cfg[\"wizboard\"][\"ListMemberGrade\"]			=\"$ListMemberGrade\";
\$cfg[\"wizboard\"][\"ListMemberGradeBoundary\"]	=\"$ListMemberGradeBoundary\";
\$cfg[\"wizboard\"][\"ListMemberGenderBoundary\"]	=\"$ListMemberGenderBoundary\";
\$cfg[\"wizboard\"][\"ReadForMember\"]				=\"$ReadForMember\";
\$cfg[\"wizboard\"][\"ReadMemberGrade\"]			=\"$ReadMemberGrade\";
\$cfg[\"wizboard\"][\"ReadMemberGradeBoundary\"]	=\"$ReadMemberGradeBoundary\";
\$cfg[\"wizboard\"][\"ReadMemberGenderBoundary\"]	=\"$ReadMemberGenderBoundary\";
\$cfg[\"wizboard\"][\"WriteForMember\"]				=\"$WriteForMember\";
\$cfg[\"wizboard\"][\"WriteMemberGrade\"]			=\"$WriteMemberGrade\";
\$cfg[\"wizboard\"][\"WriteMemberGradeBoundary\"]	=\"$WriteMemberGradeBoundary\";
\$cfg[\"wizboard\"][\"WriteMemberGenderBoundary\"]	=\"$WriteMemberGenderBoundary\";
\$cfg[\"wizboard\"][\"DownForMember\"]				=\"$DownForMember\";
\$cfg[\"wizboard\"][\"DownMemberGrade\"]			=\"$DownMemberGrade\";
\$cfg[\"wizboard\"][\"DownMemberGradeBoundary\"]	=\"$DownMemberGradeBoundary\";
\$cfg[\"wizboard\"][\"DownMemberGenderBoundary\"]	=\"$DownMemberGenderBoundary\";
\$cfg[\"wizboard\"][\"ProhibitExtention\"]			= \"$ProhibitExtention\";
\$cfg[\"wizboard\"][\"CategoryEnable\"]				= \"$CategoryEnable\";
\$cfg[\"wizboard\"][\"CategoryType\"]				= \"$CategoryType\";

\$cfg[\"wizboard\"][\"writePoint\"]					= \"$writePoint\";\#\#작성 포인트
\$cfg[\"wizboard\"][\"writeExp\"]					= \"$writeExp\";\#\#작성 경험치
\$cfg[\"wizboard\"][\"writePer\"]					= \"$writePer\";\#\#일별 포인트/경험치 제한수

\$cfg[\"wizboard\"][\"commentPoint\"]				= \"$commentPoint\";\#\# 댓글(리플) 포인트
\$cfg[\"wizboard\"][\"commentExp\"]					= \"$commentExp\";\#\#댓글(리플) 경험치
\$cfg[\"wizboard\"][\"commentPer\"]					= \"$commentPer\";\#\#일별 포인트/경험치 제한수

\$cfg[\"wizboard\"][\"replyPoint\"]					= \"$replyPoint\";\#\#리플라이 포인트
\$cfg[\"wizboard\"][\"replyExp\"]					= \"$replyExp\";\#\#리플라이 경험치
\$cfg[\"wizboard\"][\"replyPer\"]					= \"$replyPer\";\#\#일별 포인트/경험치 제한수

\$cfg[\"wizboard\"][\"rccomPoint\"]					= \"$rccomPoint\";\#\# 추천 포인트
\$cfg[\"wizboard\"][\"rccomExp\"]					= \"$rccomExp\";\#\# 추천 경험치

\$cfg[\"wizboard\"][\"rccomnonPoint\"]				= \"$rccomnonPoint\";\#\# 비추천 포인트
\$cfg[\"wizboard\"][\"rccomnonExp\"]					= \"$rccomnonExp\";\#\# 비추천 경험치

\$cfg[\"wizboard\"][\"bp_recommand\"]				= \"$bp_recommand\";\#\#추천포인트
\$cfg[\"wizboard\"][\"bp_nonerecommand\"]			= \"$bp_nonerecommand\";\#\#비추천포인트
\$cfg[\"wizboard\"][\"bp_reple\"]					= \"$bp_reple\";\#\#리플포인트(코멘트, 댓글)
\$cfg[\"wizboard\"][\"bp_reply\"]					= \"$bp_reply\";\#\#리플라이 포인트
\$cfg[\"wizboard\"][\"np_lv10\"]					= \"$np_lv10\";\#\#10레벨에 도달 필요포인트
\$cfg[\"wizboard\"][\"np_lv20\"]					= \"$np_lv20\";\#\#20레벨 도달 필요포인트
\$cfg[\"wizboard\"][\"np_lv30\"]					= \"$np_lv30\";\#\#30레벨 도달 필요 포인트
?>"; 
$fp = fopen("../config/wizboard/table/$GID/$BID/config.php", "w"); 
$STRING=stripslashes($STRING);
fwrite($fp, "$STRING"); 
fclose($fp); 