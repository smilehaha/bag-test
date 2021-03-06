<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
use frontend\controllers\SurveyController;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */

// echo $this->renderFile(__DIR__.'/../layouts/head.php');
// echo $this->renderFile(__DIR__.'/../layouts/head-answer.php',['model'=>$model]);
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');


$this->title=isset($survey_tax[$model->tax])? $survey_tax[$model->tax] : $survey_tax['0'];
$submitAddText = '';
$submitNexText = '';
$text_hint = '';
switch ($model->tax):
    case 1:

        break;
    case 2:

    case 3:
        $this->title = '跳转型测试-步骤5.设置跳转';
        $submitAddText = '保存/增加';
        $submitNexText = '保存/下一步添加结果';
        $text_hint = "（1）将选项跳转到后面的题目，逐个跳转后，最后跳转到测试结果。大家做测试时将按照你设定的跳转做题，并测出结果。<br/>
（2）设定跳转后保存，在下一步，你需要预览一下已经添加的全部内容。如果没有问题，发布出去之后，成千上万的人都可以做这个测试啦。<br/>
（3）后面还有最后1个步骤，这个测试就能创建完毕，加油。";
        break;
endswitch;



/**
 * 显示跳转到多少题
 * @param unknown $name
 * @param unknown $start
 * @param unknown $end
 * @param string $select
 * @return string
 */
function selectShow($name,$start,$end,$select=''){
    if($start-1==$end){
        return '';
    }
    echo '<select class="select-question" name="',$name,'"><option value="" >请选择跳转问题</option>';

    for($start;$start<=$end;$start++){
        $selected = $select==$start ? 'selected="selected"':'';
        echo '<option ',$selected,' value="',$start,'">跳转到',$start,'题</option>';
    }
    echo '</select>';
}

// ZCommonFun::print_r_debug($models_SurveyResulte);
// exit;
function selectShowResulte($models_SurveyResulte,$selected_id,$name=''){
    $i = 0;
    echo '<select class="select-resulte" name="',$name,'"><option value="" >请选择结果</option>';
    foreach ($models_SurveyResulte as $key=>$row){
        $selected = $selected_id==$row->sr_id ? 'selected="selected"':'';
        $i++;
        echo  '<option value="',$row->sr_id,'" ',$selected,'>结果',$i,'</option>';

    }
    echo '</select>';
}



?>
<style>
.s_login div,.s_reg div{
	padding:0;
	text-align: left;
}
.s_reg .btn_bg{
	display: block;
	width: 100%;
	padding: 0;
}.s_reg input[type=button]{
	width: 98.5%;
}
.s_reg{
	margin-bottom: 30px;
}
fieldset {
	border:none;
}
.question-item{
	display:block;
}
</style>
<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
<section class="s_moreread s_reg s_login">
        <?php $form = ActiveForm::begin(['id'=>'id-form']); ?>
            <h1 class="po_title common-color node-title"><?php echo $model->title;?></h1>
            <div id="id_question_list" style="display: none1" data-type="score">

                <?php
                $question_count = count($data['questions']);
                foreach ($data['questions'] as $key=>$question){
                ?>
				<div id="id_question_list" class="question-item">
					<div class="hide">第<?php echo $key+1;?>题</div>

					<fieldset data-role="controlgroup"
						class="ui-corner-all ui-controlgroup ui-controlgroup-vertical">
						<div role="heading" class="ui-controlgroup-label"><?php echo $key+1,'.',$question->label; ?></div>
						<div class="ui-controlgroup-controls">
							<?php
                            isset($data['options'][$key]) ? null : $data['options'][$key]=[];
                            foreach ($data['options'][$key] as $key2=>$option){
                            ?>
							<label for="option-id-<?php echo $option->qo_id;?>" >

									<input type="radio" id="option-id-<?php echo $option->qo_id;?>" name="options[<?php echo $question->question_id; ?>][]" value="<?php echo $option->qo_id;?>">
									<span ><?php echo '选项'.($key2+1).'.'.$option->option_label;?></span>
								    <?php echo selectShow("option[{$option->qo_id}]", $key+2, $question_count,$option->skip_question);?>
								    <?php echo selectShowResulte($models_SurveyResulte, $option->skip_resulte,"resulte[{$option->qo_id}]");?>
							</label><br/>
                            <?php } ?>

						</div>
					</fieldset>

				</div>
                <?php } ?>

			</div>

			<div class="s_reg">
    			<a class="btn_bg" href="<?php echo Yii::$app->urlManager->createUrl(['survey/step4_2','id'=>$model->id]);?>">
        			<input type="button" id="submit" value="上一步">
        		</a>
    		</div>

			<div class="s_reg">
    			<a class="btn_bg" href="javascript:void(0);">
        			<input type="submit" id="submit" value="保存/最后一步 预览">
        		</a>
    		</div>
    		<br />
    		<p class="text-hint"><?php echo $text_hint;?></p>
    		<br />
    		<br />
    		<br />
    		<br />
        <?php ActiveForm::end(); ?>
</section>
<script type="text/javascript">
Array.prototype.unique2 = function()
{
	var n = {},r=[]; //n为hash表，r为临时数组
	for(var i = 0; i < this.length; i++) //遍历当前数组
	{
		if (!n[this[i]]) //如果hash表中没有当前项
		{
			n[this[i]] = true; //存入hash表
			r.push(this[i]); //把当前数组的当前项push到临时数组里面
		}
	}
	return r;
}
$(document).ready(function(){
	//点击问题
	$("label").on('click','.select-question',function(){
		var value = $(this).val();
		var resulte = $(this).closest('label').find('.select-resulte');
		if(value>0){

			resulte.find('option:selected').attr('selected',false);
			resulte.hide();
		    console.log(value+'--'+resulte.val() );
	    }else{
	    	resulte.show();
		}
	});

	//点击结果
	$("label").on('click','.select-resulte',function(){
		var value = $(this).val();
		var resulte = $(this).closest('label').find('.select-question');
		if(value>0){
			resulte.find('option:selected').attr('selected',false);
			resulte.hide();
		    console.log(value+'--'+resulte.val() );
	    }else{
	    	resulte.show();
		}
	});
	$(".select-question,.select-resulte").click();

	/*
	$("select.select-question").on('change',function(){
		var now = $(this);
		//获取当前选中值
		var value = now.val();
		if(value){
			now.attr('valueid',value);
		}else{
			now.removeAttr('valueid');
		}

		var arr_select = new Array();
		//当前值被选中就显示，没被选中就隐藏
	    $("select.select-question[valueid]").each(function(){
		    var row = $(this);
		    var row_value = row.attr('valueid');
		    arr_select.push(row_value);
		    $("select.select-question option[value='"+row_value+"']:not(:selected)").hide();
		    $("select.select-question option[value='"+row_value+"']:selected").show();
		});
	    arr_select = arr_select.unique2();
// 		console.log(arr_select);
		$("select.select-question:not([valueid]) option").each(function(){
			var row = $(this);
			var row_value = row.attr('value');
			var op = false;
		    for(var i in arr_select){
			    if(arr_select[i]==row_value){
			    	row.hide();
			    	op = true;
			    	break;
				}
			}
// 			console.log(op,row_value);
		    op? null : row.show();
		});
	});
	$("select.select-question").change();
	*/
});
</script>
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>