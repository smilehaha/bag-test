<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
use common\models\SurveyResulte;
use frontend\controllers\SurveyController;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
$a_SurveyResulte = [];
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$tax])? $survey_tax[$tax] : $survey_tax['0'];

$submitAddText = '';
$submitNexText = '';
$text_hint = '';
switch ($model->tax):
    case 1:
        $this->title = '无题测试-步骤3. 添加测试结果';

        $submitAddText = '增加一个结果';//'保存/增加';
        $submitNexText = '保存/下一步 选择测试算法';//'保存/下一步选择算法';
        $text_hint = "（1）填写测试结果，并为这个结果配图。<br/>
（2）点击“增加结果”后，你可以继续再添加一个测试结果。<br/>
（3）添加完所有测试结果后保存。在下一步，你需要选择一种测试算法。<br/>
（4）后面还有2个步骤，这个测试就能创建完毕。
        ";
    break;
    case 2:
        $this->title = '分数型测试-步骤5. 添加测试结果';


        $submitAddText = '增加一个结果';
        $submitNexText = '保存/最后一步 预览';
        $text_hint = "（1）填写测试结果，并为这个结果配图，设置该结果的分数区间。<br/>
（2）如果想再添加一个测试结果，请点击“增加结果”。<br/>
（3）添加完所有测试结果后保存。在下一步，你需要预览一下已经添加的全部内容。如果没有问题，发布出去之后，成千上万的人都可以做这个测试啦。<br/>
（4）后面还有1个步骤，这个测试就能创建完毕，加油。
        ";
        break;
    case 3:
        $this->title = '跳转型测试-步骤4. 添加测试结果';

        $submitAddText = '增加一个结果';
        $submitNexText = '保存/下一步设置跳转';
        $text_hint = "（1）填写测试结果，并为这个结果配图。<br/>
（2）如果想再添加一个测试结果，请点击“增加结果” 。<br/>
（3）添加完所有测试结果后保存。在下一步，你需要设定跳转，让选项跳转到后面的题目和测试结果。<br/>
（4）后面还有2个步骤，这个测试就能创建完毕。<br/>
        ";
        break;
endswitch;


$question_total_score = isset($question_total_score) ? intval($question_total_score) : 0;
$question_total_min_score = isset($question_total_min_score) ? intval($question_total_min_score) : 0;
?>
<link rel="stylesheet" href="./css/edit.css">
<style>
.s_login div,.s_reg div{
	padding:0;
}
.s_reg .btn_bg{
	display: block;
}
.form-group{
	text-align: left;
	font-weight: bold;
}
.s_reg form{
	margin-top: 1em;
}
.po_title{
	text-align: left;
	font-size: 2em;
}
.intro{
	text-align: left;
	color: #999;
	text-indent: 2em;
}

.row{
	border-bottom: 3px dashed #DDD;
	margin-top: 1em;
}
.label-name{
    display: block;
    text-align: left;
}
.row textarea ,.row input,.s_reg input[type=text], .s_reg input[type=password], .s_reg textarea{
	width: 99%;
	height: 2em;
	line-height:2em;
	padding: 0;
	margin: 0;
	float: left;
	margin-bottom: 0.5em;
}
.s_reg .btn_bg{
    float: left;
	width: 30%;
	border: none;
	margin: 0;
}
.s_reg .add-btn{
	margin-left: 3.8%;
}
.s_reg .btn_bg.btn-r{
	float: right;
}
.s_reg .btn_bg.save{
	float: right;
}

.s_reg .btn_bg.btn-100{
	width: 98.5%;
	float: left;
	margin-top: 20px;
    margin-bottom: 20px;
}

.row>label,.options>select,.options>label{
	margin: 0.5em 0;
	float: left;
}

.BlankBlock .BlockTitle h2 {
    color: #262626;
    font-size: 16px;
    line-height: 24px;
    letter-spacing: -1px;
    text-align: left;
}
.BlankBlock .BlockCon textarea {
    border: 1px solid #c9c9c9;
    /* padding: 5px; */
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 0;
	/* height: 4.5em;*/
}
.BlankBlock .BlockCon textarea.last{
	height: 4.5em;
}
.QaddImg,.field-images-image label{
float: left;
text-align:left;
}

#BlockCon{
    position: relative;
	width: 75px;
	height: 45px;
	display: inline-block;

}

.field-images-image label{
	font-size: 2em;
	line-height: 45px;
	color: #2E8EC1;
}
.field-images-image{
	text-align: center;
	margin-bottom: 10px;
}
#BlockCon input{
	display: none;
}
.QaddImg {
    position: absolute;
    right: 10px;
    top: 11px;
    width: 60px;
    height: 55px;
    margin: 0 auto;
    overflow: hidden;
    background-position: 0 0;
    background-repeat: no-repeat;
    background-size: contain;
    background-image: url('./images/camera.png');
}
    #upload{
	display: none;
    height: 0;
    	width:0;
    }
.s_reg div.resulte{
	border: 1px solid #ddd;
	font-size: 1.2em;
	padding: 5px;
}
.resulte span{
	font-size: 1.5em;
	color: blue;
}
.BlockCon.core{
	text-align: left;
}
</style>

<div id="main_body">
    <?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>

    <section class="s_moreread s_reg s_login">
    <?php $form = ActiveForm::begin(['id'=>'form1','action'=>['survey/step4_2','id'=>$model->id,'page'=>$page+1]]); ?>
        <h1 class="po_title common-color node-title"><?php echo $model->title;?></h1>
        <div class="BlankBlock">

             <div class="BlockTitle">
				<h2 class="text-red">第<?php echo $page;?>测试结果</h2>
			</div>
			<div class="BlockCon InputBor_pr0">
				<textarea name="SurveyResulte[name]" id="SurveyResulte-name"  maxlength="15"
				class="topic_input" type="text" placeholder="请输入姓名之前的内容，限15个字"><?php echo $model_SurveyResulte->name;?></textarea>
			</div>
			<div class="BlockTitle">
				<h2>姓名</h2>
			</div>
			<div class="BlockCon InputBor_pr0">
				<textarea name="SurveyResulte[value]" id="SurveyResulte-value"  maxlength="15"
				class="topic_input" type="text" placeholder="请输入姓名之后的内容，限15个字" ><?php echo $model_SurveyResulte->value;?></textarea>
			</div>
		</div>
		<div class="BlankBlock" style="text-align: left;">
				比如，在姓名前输入“经测试认为”，在姓名后输入“是《甄嬛传》中的甄嬛”，那么，张三在测试时，测试结果可能会是“经测试认为<span style="color:#FE8C78;font-weight:bold;">张三</span>是《甄嬛传》中的甄嬛。”
		</div>
		<div class="BlankBlock">
		    <div class="BlockTitle">
				<h2>测试结果详情</h2>
			</div>
			<div class="BlockCon InputBor_pr0">
				<textarea  name="SurveyResulte[intro]" id="SurveyResulte-intro"
				class="topic_input last" type="text" placeholder="测试结果详情" ><?php echo $model_SurveyResulte->intro?></textarea>
			</div>
		</div>
		<?php if($tax==2){?>
		<div class="BlankBlock">
		  <div class="BlockTitle">
				<h2>选择分数范围</h2>
				<div class="BlockCon core">
				    <select name="SurveyResulte[score_min]" id="SurveyResulte-score_min">
				        <?php
				        echo $question_total_min_score>$question_total_score ? '<option value="">分数区间已经选择完了</option>' : '';
				        ?>
				    </select>
				    到
				    <select name="SurveyResulte[score_max]" id="SurveyResulte-score_max">
				        <?php
				        echo $question_total_min_score>$question_total_score ? '<option value="">分数区间已经选择完了</option>' : '';
				        ?>
				    </select>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="form-group field-images-image">
            <label class="control-label upload-click" for="images-image">上传图片结果配图
                <div id="BlockCon" class="">
                    <i class="QaddImg ">
                    </i>
                </div>
            </label>
            <input id="upload" type="file" name="file">
            <input type="hidden"  name="sr_id" value="<?php echo $model_SurveyResulte->sr_id;?>" >
            <input type="hidden" id="SurveyResulte-image"

            class="form-control " name="SurveyResulte[image]" value="<?php echo $model_SurveyResulte->image;?>">

            <div class="help-block"></div>
        </div>
		<div id="image-wrap">
            <?php

                if(isset($model_SurveyResulte->image) && !empty($model_SurveyResulte->image)){
                    echo '<img src="',$image = SurveyResulte::getImageUrl($model_SurveyResulte),'"/>';
                }
            ?>
        </div>
        <br/>
        <div class="btn_bg btn-2" style="padding:0;" >
            <?php
            $prv_url = Yii::$app->urlManager->createUrl(['survey/step4_2_question','id'=>$model->id]);
            $model->tax == 2 ? $prv_url = Yii::$app->urlManager->createUrl( ['survey/step4_3','id'=>$model->id] ) : '';
            $model->tax == 1 ? $prv_url = Yii::$app->urlManager->createUrl( ['survey/step1_3','id'=>$model->id] ) : '';
            $model->tax == 3 ? $prv_url = Yii::$app->urlManager->createUrl( ['survey/step4_2_question','id'=>$model->id] ) : '';
            ?>
			<a  style=""
			href="<?php echo $prv_url;?>"
			id="prev-step">上一步</a>
		</div>

        <div class="btn_bg btn-2 btn-100" style="margin:0;margin-left:4.6%;max-width: 30%;padding:0;" >
			<a
			href="<?php echo Yii::$app->urlManager->createUrl(['survey/result-delete','id'=>$model->id,'page'=>$page]);?>"
			id="prev-step">删除</a>
		</div>


        <button type="submit" name="save-next" class="btn_bg add-btn" style="float:right;margin-left: 0;max-width: 30%;padding:0;"><?php echo $submitAddText;?></button>

		<a class="btn_bg" style="display:none;width: 98.5%;margin-top: 15px;"
		href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button"  value="预览">
	    </a>

        <button type="submit" name="save" class="btn_bg btn btn-primary save" style="width: 100%;margin: 20px 0 20px 0;"><?php echo $submitNexText;?></button>

 <?php ActiveForm::end(); ?>
            <p class="text-hint"><?php echo $text_hint;?></p>
            <br/>
            <div class="BlockTitle">
				<h2 class="text-red">本测试结果预览</h2>
			</div>
        <div class="resulte">

		</div>
    </section>
 </div>
 <script src="common/php-html5-uploadz/ZHtml5Upload.js">
</script>
<script type="text/javascript">
var resulte_count = <?php echo $count;?>;

function loadSelect(element,selected,start,end){
	start = start ? start : 1;
	end = end ? end : 5;
	selected = selected ? selected : $(element).attr('selectedvalue');
	var html = loadOptions(start,end,selected);
	$(element).append(html);
}
function loadOptions(start,end,selected){
	var html = '';
	for(var i=0;start<=end;start++){
		if(selected==start){
			html += '<option selected="selected" value="'+start+'">'+start+'分</option>';
	    }else{
	    	html += '<option value="'+start+'">'+start+'分</option>';
		}
	}
	console.log(html);
	return html;
}
$(document).ready(function(){
	<?php
	if($tax==2 && $question_total_min_score<=$question_total_score){
	?>
	loadSelect('#SurveyResulte-score_min',<?php echo $model_SurveyResulte->score_min>0 ? $model_SurveyResulte->score_min : $question_total_min_score;?>,<?php echo $question_total_min_score;?>,<?php echo $question_total_min_score;?>);
	loadSelect('#SurveyResulte-score_max',<?php echo $model_SurveyResulte->score_max>0 ? $model_SurveyResulte->score_max : $question_total_min_score;?>,<?php echo $question_total_min_score;?>,<?php echo $question_total_score;?>);
    <?php }?>
	$("#SurveyResulte-name,#SurveyResulte-value,#SurveyResulte-intro").keyup(function(){
		preview();
    });

	$(".upload-click").click(function(){
        $("#upload").click();
    });

    $("#upload").ZHtml5Upload({
		uploadSucess: function(result,uploadz){
			var json = $.parseJSON(result);
			//console.log( json );
			if( json.result.status==1 && json.id){
				$("#SurveyResulte-image").val(json.id);
		    }

			//console.log(this);
			if( uploadz.isReaderFile ){
				$("#image-wrap").empty();
// 				$("#image-wrap").append('<img src="'+uploadz.base64Data+'" />');
				$("#image-wrap").append('<img src="<?php echo Yii::$app->request->baseUrl,UPLOAD_DIR;?>'+json.id+'" />');
				preview();
			}
			console.log( uploadz.base64Data );
		},
		uploadError: function(result){
			console.log( result);
		}
	});

// 	$("form").submit(function(){
// 		if(resulte_count>0){
// 			return true;
// 		}
// 		return submitValid();
// 	});
	preview();
});

function preview(){
	$(".resulte").empty();
	var name = $("#SurveyResulte-name").val();
	var value = $("#SurveyResulte-value").val();
	var intro = $("#SurveyResulte-intro").val();
	$(".resulte").append(name);
	$(".resulte").append('<span>姓名</span>');
	$(".resulte").append(value);
	$(".resulte").append('<hr />');
	$(".resulte").append(intro);
	$(".resulte").append( $("#image-wrap").html() );
}
function submitValid(){
	var name = $("#SurveyResulte-name").val();
	var value = $("#SurveyResulte-value").val();
	var image = $("#SurveyResulte-image").val();
	var intro = $("#SurveyResulte-intro").val();
	if(!name){
		$("#SurveyResulte-name").focus();
		alert("请输入名字之前内容");
		return false;
    }
	if(!value){
		$("#SurveyResulte-value").focus();
		alert("请输入名字之后内容");
		return false;
    }
	if(!image){
		alert("请上传图片");
		return false;
    }
    return true;
}
</script>
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>