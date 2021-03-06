<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
use common\models\UserProfile;
/* @var $model common\models\Survey */
/* @var $model_AnswerUser common\models\AnswerUser */
/* @var $model_SurveyResulte common\models\SurveyResulte; */

$test_url = $model->tax==1 ? 'answer/step1':'answer/step2-answer2';
$test_url = Yii::$app->urlManager->createAbsoluteUrl([$test_url,'id'=>$model->id]);

$create_url = Yii::$app->urlManager->createUrl(['survey/step1','id'=>$model->id]);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" itemprop="description"
	content="<?php echo ZController::$site_name;?>" id="qDesc">
<meta name="keywords" content="<?php echo $model->title;?>">
<title>
<?php 
echo empty(ZController::$site_name) ? '':ZController::$site_name.' - ';
echo $this->title,' ',$model->title;
?>
</title>
<script type="text/javascript" src="./js/jquery.js"></script>
<link rel="stylesheet" href="./css/v1.css">
<style type="text/css">
.user-info{
    width: 91.5%;
    margin: 0 auto;	
	background: #f5f5f5;
    border: 2px solid #ddd;
	    overflow: hidden;
}
.user-info table{
	width: 100%;
	margin: 20px;
}
.red{
	color: red;
}
.list-a{
	float: left;
	width: 48%;
	text-decoration: none;
	margin-bottom: 10px;
}
.list-a h5 {
  width:100%;
  overflow:hidden;
  text-overflow:ellipsis;
  -o-text-overflow:ellipsis;
  -webkit-text-overflow:ellipsis;
  -moz-text-overflow:ellipsis;
  white-space:nowrap;
}
.list-a-1{
	float: left;
	
}
.list-a-0{
	float: right;
	
}
.list-a img{
	height: 120px;
	width: 100%;
}
</style>
</head>
<body>
	<div id="mainbox" class="main">
		<div id="bg1" class="bg1">
			<img id="topimg1" class="topimg imgshow" src="./images/clips1.png">
			<div class="bg2"></div>
			<div id="maintext-title" class="maintext maintext-ready mainactive maintext-play">
				
				<div  class="maindesc">
				    <p>
				        <?php 
				        echo $model_SurveyResulte->name;
				        echo $model_AnswerUser->answer_name ? '<span class="answer-name">'.$model_AnswerUser->answer_name.'</span>' : '';
				        echo $model_SurveyResulte->value;
				        ?>
				    </p>
				    <hr />
				    <div id="home-title" class="maintitle"><?php echo $model->title;?></div>
				    <?php 
				    if($image)
				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
				    ?>
				    
				    <?php echo $model_SurveyResulte->intro;?>
				</div>
			</div>
			
			
			<div id="maintext-result" class="maintext maintext-result">
				<div id="result-title" class="resuletitle"></div>
				<div id="result-desc" class="resuledesc"></div>
			</div>

			<!-- btn -->
			<div id="gameready" class="btnbox btn-ready btnactive">
				<p onclick="javascript:location.href='<?php echo $test_url;?>';">我要测一测</p>
			    <p onclick="javascript:location.href='<?php echo $create_url;?>';" 
				style="margin-top: 30px;">创建我的测试</p>
			</div>

			

			<div id="gameend" class="btnbox btn-more">
				<p >更多测试</p>
			</div>
		</div>
		
		<div class="user-info">
		  <div style="height: 3.5em;overflow: hidden;">
		  <?php echo $this->renderFile(__DIR__.'/../layouts/share.php'); ?>
		  </div>
		    <div>
		      <table>
		          <tr>
		              <td align="right">
		                  <img src="<?php echo $model_UsersProfile->getHeadImage0();?>" />
		              </td>
		              <td align="left" style="vertical-align: top">
		                  
		                  <label>创建测试者：
		                      <b><?php echo $model_UsersProfile->getNickname0();?></b>
		                  </label>
		                  <div class="user-intro">
		                      <?php echo $model_UsersProfile->getIntro0();?>
		                  </div>
		                  <div class="user-test-info">
		                                                  创建了<span class="red"><?php echo $model_UsersProfile->test_count;?></span>个测试，被测试过<span class="red"><?php echo $model->answer_count;?></span>次，准确率<span class="red"><?php echo UserProfile::getRate0(); ?></span>。
		                  </div>
		              </td>
		          </tr>
		      </table>
		   </div>
		</div>
		
		<div class="user-info">
		  <div style="height: 3.5em;line-height: 3.5em;overflow: hidden;    font-size: 1.5em;">
		  下面这些测试页不错，你想试一下嘛
		  </div>
		   <?php 
		   foreach ($randSurvey as $key=>$row){
		       $key_index = $key+1;
		       if($row->tax==1){
		           $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
		       }else{
		           $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
		       }
		       $image = isset( $row->images->image ) ? UPLOAD_DIR.$row->images->image : DEFAULT_IMAGE;
		   ?>
	       <a class="list-a list-a-<?php echo $key_index%2;?>" href="<?php echo $url;?>">
	           <img src="<?php echo $image;?>" />
	           <h5><?php echo $row->title;?></h5>
	       </a>
	       <?php }?>
		</div>
		
		<!-- comment start -->
		
		<?php 
        echo $this->renderFile(__DIR__ . '/../comment/static-list.php',['model'=>$model_SurveyResulte]);
        
        ?>
		<!-- comment end -->
	</div>
	<?php 
        echo $this->renderFile(__DIR__ . '/../layouts/foot-comment.php',['model'=>$model_SurveyResulte]);
        ?>
    
    <script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		var index = 0; 
		$("#gameready,.btn-play .span").click(function(){
			//zhao start 屏蔽 name和age元素动画	
			var name = $(this).find('#name');
			if( name && name.val()=="" ){
			    return true;
		    }
			var age = $(this).find('#age');
			if( age && age.val()=="" ){
			    return true;
		    }
			//zhao end 屏蔽 name和age元素动画	
			$(".maintext-play").eq(index).animate({marginLeft:"-"+$(".maintext-play").eq(index).width()},'slow',function(){
				$(".maintext-play").eq(index).hide();
				$(".maintext-play").eq(index+1).fadeIn('slow');
				$("#gameready").hide();
				index++;
		    });	    
		});	

		$(".btnbox-submit").click(function(){

			var name = $('#name');
			if( name && name.val()=="" ){
				alert("请输入姓名");
			    return true;
		    }
			var age = $('#age');
			if( age && age.val()=="" ){
				alert("请输入年龄");
			    return true;
		    }
		    $("form").submit();
	   });
		   
    });
		
	</script>
</body>
</html>
