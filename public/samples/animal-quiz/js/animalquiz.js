var init_time = 20;
var aAnswer = [];
var aData = [];

$(function() {

    var base_url = quiz.base_url();
    var number_of_quiz = 0;
    var startTimer = "";
	
    function init() {
        $('#num_quiz option:eq(0)').attr('selected',true);
        $('#num_quiz, #quiz_btn').attr('disabled',false);
        $('#quiz_again').hide();
        $('#seq').text("");
    }

    init();
	
    $(document).on('click', '.btn_hover', function() {
        $(this).parents('#option_container').find('.btn_hover').removeClass('answer_picked').end().end().addClass('answer_picked');
    });

    // begin quiz button
    $('#quiz_btn').click(function(){

        number_of_quiz = parseInt($('#num_quiz').val());
        if(number_of_quiz > 0){
            // show label on  user's instruction
            $('#label_select_pic').removeClass('hide_me');
            aData = quiz.get_quiz(number_of_quiz);
            quiz.render_quiz(aData);
            $('#seq').text('1 of '+number_of_quiz);		
            startTimer = start_timer(init_time);
            // reset
            aAnswer = [];
            $(this).attr('disabled',true);
            $('#num_quiz').attr('disabled',true);
            if($('#timer').hasClass('hide')){
                $('#timer').removeClass('hide');
            }
        }
    });

    // user's submit button
    $(document).on('click', '.submit_btn', function() {

        var obj = $(this);
        var parent = obj.parents('.row');
        var answer_picked = parent.find('.answer_picked');
		
        if(answer_picked.length == 0){
            $('#modal_msg').modal('show');
            return false;
        }
        stop_timer();
        execSubmit();

    });

    $('#quiz_again').click(function(){
        var row = '<div class="row">\
                        <div class="col-md-8 well">\
                                <center><h4>Please select number of quiz to begin.</h4></center>\
                        </div>\
                </div>';

        $("#quiz_container").html(row);
        init();
        $('#quiz_form').show();
			
    });
	
    function execSubmit() {
	
        var timer = parseInt($('#timer').text());
        var obj = $('.submit_btn:visible');
        var parent = obj.parents('.row');
        var answer_picked = parent.find('.answer_picked');
        var user_answer = answer_picked.length == 0 ? 0 : answer_picked.data('id');
        var question = parent.find('#question').text();
        question = question.toLowerCase();
        var aUserAnswer = {
            id:user_answer,
            question:question
        };
        var index = parent.next().data('index');
        var num = (typeof index == 'undefined') ? number_of_quiz : index;
		
        $('#seq').text(num + ' of '+number_of_quiz);

        aAnswer.push(aUserAnswer);
        // if last number of quiz
        if(typeof index == 'object'){
            var correct = 0;
            $.each(aData, function(k,v){
                if(v.id == aAnswer[k].id){
                    correct = correct + 1;
                }
            });
		
            if(correct == number_of_quiz){
                message = 'Perfect score';
                is_perfect = 'hide';
            }else{
                var score =   correct * 100 / number_of_quiz;
                message = 'Your total score is '+correct+' out of '+number_of_quiz + '  ('+score+'%)';
                is_perfect = '';
            }
            var str = '<div class="row">\
					<div class="col-md-8 well">\
						<center><h4>'+message+'</h4></center>\
						<center class="'+is_perfect+'"><a class="btn review_exam">Do you want to review your scores?</a></center>\
					</div>\
					<div id="review_exam_container" style="display:none;"></div>\
				</div>';
            $('#quiz_container').html(str);
            $('#seq').text('Result');
	
            $('#quiz_form').hide();
            $('#quiz_again').show();
            $('#label_select_pic').addClass('hide_me');

            stop_timer();
            $('#timer').addClass('hide');

        }
	
        parent.next().slideDown();
        parent.remove();
        starTimer = start_timer(init_time);

    }
    $(document).on('click', '.review_exam', function(){
        var str = '<div class="col-md-12 form-group">\
                    <span class=" right_answer box img-rounded">Correct</span>&nbsp;&nbsp;\
                    <span class="wrong_answer box img-rounded">Wrong</span>&nbsp;&nbsp;\
                    <span class="no_answer box img-rounded">No Answer</span>\
                    </div>';
        $.each(aData, function(k,v) {
            var choices = v.choices;
            var question = v.animal;
            question = question.toUpperCase();
			
            str += '<h5 class="col-md-12" style="padding-buttom:2px">'+(k+1)+'.) '+question+'</h5>';
            var answer_hadler = '';
            
            var inner_str = '';
            $.each(choices, function(key,id){
                var is_correct = (id == v.id) ? 'glyphicon glyphicon-ok' : 'glyphicon';
                var user_answer = "";
                if(aAnswer[k].id == id) {
                    answer_hadler = id == v.id ? 'right_answer' : 'wrong_answer';
                    user_answer =  'user_answer';
                }else if(aAnswer[k].id == 0) {
                    answer_hadler = 'no_answer';
                }
                 
                inner_str += '<div class="col-md-3" >';
                inner_str += '<center><div class="col-md-12"><i class="'+is_correct+'"></i></div>';
                inner_str += '<div class="col-md-12"><img width="100" class="img-rounded '+user_answer+'" src="samples/'+base_url+'img/animals/'+id+'.jpg"/></div></center>';
                inner_str += '</div>';
            });
            str += '<div class="col-md-12 img-rounded '+answer_hadler+'" style="padding:5px 0 10px 0">';
            str += inner_str;
            str += '</div>';
			
        });
        $('#review_exam_container').addClass('col-md-8 well').html(str);
        $('#review_exam_container').slideDown();
        $(this).hide();
    });
	
	
    function start_timer(timer) {
        startTimer = setTimeout(function() {

            $('#timer').text(timer--);		
            start_timer(timer);
			
            if(timer < 0){
                stop_timer();
                execSubmit();
            }else if(timer < 10 && timer > 1){
                if($('#timer').hasClass('green')){
                    $('#timer').removeClass('green').addClass('red');
                }
				
            }else if(timer > 10){
                if($('#timer').hasClass('red')){
                    $('#timer').removeClass('red').addClass('green');
                }
            }
	
            if($('.review_exam').length > 0){
                stop_timer();
            }

        },1000);
    }
	
    function stop_timer() {
        clearTimeout(startTimer);
    }
	
});

var quiz = {

    base_url : function() {
        return $('#base_url').val();
    },
	
    get_quiz : function(num) {
        var base_url = quiz.base_url();
        var result = "";
        $.ajax({
            url : base_url + 'take-quiz/'+num,
            dataType : 'json',
            async : false,
            success : function(data) {
                result = data;
            }
			
        });
	
        return result;
    },

    render_quiz : function(data) {
	
        var str = "";
        var base_url = quiz.base_url();

        $.each(data, function(k,v){

            var choices = v.choices;
            var answer = v.id;
            var question = v.animal;
            var is_hide = k > 0 ? 'style="display:none;"' : '';
            str += '<div class="row" '+is_hide+' data-index="'+(k+1)+'">\
				<div class="col-md-10 well">\
					<div class="col-md-12"><h4 id="question">'+question.toUpperCase()+'</h4></div>\
					<div id="option_container">\
					<div class="col-md-3 well btn btn_hover" data-id="'+choices[0]+'"><img src="/samples'+base_url+'img/animals/'+choices[0]+'.jpg" class="img-rounded"/></div>\
					<div class="col-md-3 well btn btn_hover" data-id="'+choices[1]+'"><img src="/samples'+base_url+'img/animals/'+choices[1]+'.jpg" class="img-rounded"/></div>\
					<div class="col-md-3 well btn btn_hover" data-id="'+choices[2]+'"><img src="/samples'+base_url+'img/animals/'+choices[2]+'.jpg" class="img-rounded"/></div>\
					<div class="col-md-3 well btn btn_hover" data-id="'+choices[3]+'"><img src="/samples'+base_url+'img/animals/'+choices[3]+'.jpg" class="img-rounded"/></div>\
					</div>\
					<div class="col-md-offset-3 col-md-6">\
						<form class="form-inline" role="form">\
						<center><div class="form-group"><button class="btn btn-primary submit_btn" type="button">Submit</button></div></center>\
						</form>\
					</div>\
				</div>\
			</div>';
			
        });
		
        $('#quiz_container').html(str);
        $('#timer').text(init_time);

    }

}