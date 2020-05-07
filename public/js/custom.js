// Автозаполнение вариантов слов
$('#morpheme_text').autocomplete({
	source: function(request, response){
		// Посылаем данные через ajax на сервис переводов
		$.ajax({
			type: 'GET',
			url: '/api_services/lingvo/get_full_words/'+request.term,
			data: '',
			success: function(data){
				//console.log(data);
				if (data) {
					var availableFullWords = [];
					$(data.content.words).each(function(index, value){
						availableFullWords.push(value.word);
					});
				}
			response(availableFullWords);
			}
		});
	},
	select: function(event, ui) {
		$.ajax({
			type: 'GET',
			url: '/api_services/lingvo/get_word_card/'+ui.item.value,
			data: '',
			success: function(data){
				console.log(data);
				//data = JSON.parse(data);
				if (data) {
					console.log(data);
					formAutoComplete(data);
					//$('#word_text').attr('readonly', 'readonly');
					//var removeReadonly = function(){
                    //    $(this).removeAttr('readonly');
                    //    $(this).focus();
                    //    $(this).off('click', removeReadonly);
					//};
					//$('#word_text').on('click', removeReadonly);
					get_images_by_word(data['morpheme']);
				}
			}
		});
	}
});

// Автозаполнение формы слова
function formAutoComplete(obj) {
	var form = $('form');
	clearAll(form);
	for (var key in obj) {
		var param = $(form).find($('[name='+ key +']'));
	    if (param.length == 1) {
	    	if (Array.isArray(obj[key])) {
	    		$(param).val(obj[key].join(', '));
	    	}
	    	else {
	    		$(param).val(obj[key]);
	    	}
	    }
	    else if (param.length > 1) {
	    	var inputId = $(param).filter('[value='+obj[key]+']').attr('id');
	    	var label = $('[for='+inputId+']');
            
            $(label).click();
	    }
	}
}

// Ф-я для очистки всех параметров
function clearAll(formObj) {
	$(formObj).find('input').prop("checked", false);
	//$(formObj).find('label').not(hardCheckedLabels).removeClass("success").addClass("secondary");
	$(formObj).find('input:text').val('');
	$(formObj).find('input[type="number"]').val('3');
	$(formObj).find('input[type="url"]').val('');
	$(formObj).find('textarea').val('');
	$(formObj).find('select').prop('selectedIndex',0);
	
	$(formObj).find('.illustrations-result').removeClass('hide');
	$(formObj).find('.illustrations-result').find('.label-button-image').remove();
	$(formObj).find('.illustrations-noresult').addClass('hide');
}

function get_images_by_word(morpheme){
    $.ajax({
		type: 'GET',
		url: '/api_services/google_search/get_pictures/'+morpheme,
		data: '',
		success: function(data){
			console.log(data);
			//data = JSON.parse(data);
		    fillIllustrations($('[data-parameter-name=illustrations]'), data['content']['images']);
		}
	});   
}

function fillIllustrations(parentObj, picsArr){
    if (parentObj) {
    	var resultBlock = $(parentObj).find('.illustrations-result');
    	if (picsArr.length>0) {
            for (var key in picsArr) {
            	var jsonValue = '{"url":"'+picsArr[key]['url']+'","thumbnail_url":"'+picsArr[key]['thumbnail_url']+'"}';
				var item = $('<div class="label-button-image"></div>').appendTo(resultBlock);
				var input = $('<input id="illustration-'+ key +'" name="picture" value='+jsonValue+' type="radio">').appendTo(item);
				var label = $('<label for="illustration-'+ key +'"></label>').appendTo(item);
				var thumbnail = $('<div class="thumbnail"></div>').appendTo(label);
				var img = $('<img src="'+ picsArr[key]['thumbnail_url'] +'">').appendTo(thumbnail);
			}
			$(parentObj).find('.illustrations-noresult').addClass('hide');
			$(parentObj).find('.illustrations-result').removeClass('hide');
    	}
    }
}

// TO DO
$('input:checkbox, input:radio').on('change', function(event){
	hideChildParams($(this).parents('.parameter'));
	if($(this).prop("checked")) {
		showParams(getParamsToOpen(this));
	}
});

function getParamsToOpen(currentObj) {
	if($(currentObj).attr("data-next-params")) {
		return $(currentObj).attr("data-next-params").split(' ');
	}
	return [];
}

function showParams(paramsArr) {
	if(paramsArr.length > 0) {
		$(paramsArr).each(function(i) {
			var param = $('[data-parameter-name='+ this +']');
			if ($(param).hasClass('hide')) {
				$(param).removeClass('hide');
			}
		});
	}
}
 	
// Скрыть все дочерние параметры рекурсивно HARDCODE
function hideChildParams(currentParam) {
	var nextParam = $(currentParam).nextAll('.parameter:visible').first();
	if(nextParam.length==0) { // если нет следующего параметра - прекращаем
		return;
	}
	if($(currentParam).find('[data-next-params~='+$(nextParam).attr('data-parameter-name')+']').length > 0) { // следующий параметр дочерний от текущего?
		var nextNextParam = $(nextParam).nextAll('.parameter:visible').first();
		if($(nextParam).find('[data-next-params~='+$(nextNextParam).attr('data-parameter-name')+']').length > 0) { // а у него есть дети?
			hideChildParams(nextParam); // для детей запускаем рекурсию
			hideChildParams(currentParam); // родителя закрываем как ребенка currentParam
		}
		else {
			$(nextParam).addClass('hide'); // закрываем одиночного ребенка currentParam
			clearParam(nextParam);
			hideChildParams(currentParam); // вызываем для следующего параметра
		}
	}
	return;
}

function clearParam(paramObj) {
	$(paramObj).find('input').prop("checked", false);
	$(paramObj).find('label').removeClass("success").addClass("secondary");
	$(paramObj).find('input:text').val('');
	$(paramObj).find('input[type="url"]').val('');
	$(paramObj).find('textarea').val('');
	$(paramObj).find('select').prop('selectedIndex',0);
}



function firstCharUpper(str) {
	return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
}

function createTagButton(tagName, allTagsBlock) {
	var inputId = tagName.toLowerCase().replace(/\s/ig, '_') + "_all_tags";
		$('\
		<div class="label-button">\
			<input id="'+inputId+'" name="collections[]" type="checkbox" value="'+tagName.toLowerCase()+'">\
			<label for="'+inputId+'">\
				'+tagName+'\
			</label>\
		</div>').appendTo(allTagsBlock);
}

function createTagLabel(tagName, tagsBlock) {
	var inputId = "collections_" + tagName.toLowerCase().replace(/\s/ig, '_');
	
	$('\
		<div class="label-button">\
			<input id="'+inputId+'" checked="checked" name="collections[]" type="checkbox" value="'+tagName.toLowerCase()+'">\
			<label for="'+inputId+'">\
				'+tagName+'\
			</label>\
		</div>').appendTo(tagsBlock);
	
}

var availableTags = [];
getAllTags();



// Заполняем темы слова во всех местах
function fillAllTags(data) {
	$(data).each(function(element){
		availableTags.push(firstCharUpper(this));
		createTagButton(this, $('[data-parameter-name=all_tags]'));
	});
}
// Автозаполнение при вводе лэйблов тем

$("#add_tag_text").autocomplete({
	source: availableTags,
	select: function(event, ui) {setTimeout(add_tag(ui.item.value), 100);}
});



// Получаем все возможные лэйблы с сервера
function getAllTags() {
	$.ajax({
		type: 'GET',
		url: '/get_all_collections',
		data: '',
		success: function(data){
			console.log(data);
			if (data) {
				fillAllTags(data);
			}
		}
	});
}

// Нажатие на кнопку добавление лейбла из текстового инпута
$('#add_tag_submit').click(function(){
	add_tag($('#add_tag_text').val());
	$('#add_tag_text').val('');
});


function add_tag(tagName){
	if($('.added-tags').find('[value='+tagName.toLowerCase()+']').length == 0) {
		createTagLabel(tagName, $('[data-parameter-name=collections]'));
	}
}

// Клик по кнопкe ползунка (+)
$('[data-role="btn-number-increment"]').click(function(){
	var field = $(this).parents('.counter').find('.number-field');
	
	var value = Number($(field).val());
	var max = Number($(field).attr("max"));

	if(value < max) {
		value++;
		$(field).val(value);
	}
});

// Клик по кнопкe ползунка (-)
$('[data-role="btn-number-decrement"]').click(function(){
	var field = $(this).parents('.counter').find('.number-field');

	var value = Number($(field).val());
	var min = Number($(field).attr("min"));

	if(value > min) {
		value--;
		$(field).val(value);
	}
});

// Creating a popup window
function showPopUpWindow(windowObj, contentObj, timer) {
	var popUpWindow = new Foundation.Reveal(windowObj, {'data-close-on-click':false}); // init a reveal object with options
	$(contentObj).appendTo($(windowObj)); // add content to the window
	$(windowObj).foundation('open'); // show pop up
	if (typeof timer == 'number') { // if timer variable is existed, then set timeout for window
		setTimeout(function() {
			$(windowObj).foundation('close'); // hide pop up after ... ms
		}, timer);
	}
}



// + Получить данные по тэгам с сервера
// + Отрисовать все тэги в виде кнопок
// + Автозаполнение формы добавления нового тега
// + Добавление тэга к слову
// Создание нового тэга в базе данных
// Есть ли тэг среди уже доступных
// + Создать тэг кнопку
// + Создать тэг лэйбл

// хандлер для лэйбла тэгов (чекбокс всегда выбран)


/*
// Нажатие на кнопку добавление лейбла из текстового инпута
$('.ajax-form-submit').click(function(){
	var form = $(this).parents('.ajax-form');
	$.ajax({
		type: $(form).attr('data-method'),
		url: $(form).attr('data-action'),
		success: function(data){
			
		}
	});
});

*/






/*
// Клик по параметрам
$('label').on('click', function(event){
	var doubleClick = false;
	if (isDoubleClick(this, event)) {
		doubleClick = true;
	}
    
    clickParam(this, doubleClick);
	clear(this);
	hideParam(this);
	showParam(this);
});





// Клик по кнопке Add to Dictionary
$('body').on("click", ".send", function(){
	if ($(this).hasClass('cancel')) {
		
	}
	else {
		var data = getData();
		if (textValidator(data)) {
			sendData(data);
		}
		else {
			popUpWindow('Error Data Sending!','error', 2000);
		}
		$('#word_text').trigger('click');
	}
});


$('body').on("click", ".thumbnail-pic", function(){
	clickParam(this);
});



// Функция для отрисовки поп-ап окна
function popUpWindow(text, type, timer) {
	$('#myModal').removeClass('alert');
	$('#myModal').removeClass('success');

	if (type=="error") {
		$('#myModal').addClass('alert');
	}
	else if (type=="success") {
		$('#myModal').addClass('success');
	}
	
	$('#myModal > p').html(text);
	if (!$('#myModal').hasClass('open')) {
		$('#myModal').foundation('reveal','open');
	}
	if (typeof timer == 'number') {
		setTimeout(function() {
			$('#myModal').foundation('reveal','close');
		}, timer);
	}
}


// Функция собирающая массив для отправки на сервер со всех параметров формы
function getData() {
	var result = new Array();
	var elements = $('form [name]');
	for (var i=0; i<elements.length; i++) {
		var elementName = $(elements[i]).attr('name');
		var arr = $($(elements).selector + '[name='+elementName+']');
		if (arr.length > 1) {
			var checkedElements = $($(elements).selector + '[name='+elementName+']:checked');
			if (checkedElements.length==0) {
				if (!result[elementName]) {
					result[elementName] = "";
				}
			}
			else if (checkedElements.length==1) {
				if (!result[elementName]) {
					result[elementName] = $(checkedElements).val();
				}
				if (elementName=='image') {
                    result['thumbnail'] = $(checkedElements).attr('data-thumbnail');
				}
			}
		}
		else if (arr.length == 1) {
			if ($(arr).attr('type')=="checkbox") {
				if (!result[elementName]) {
					result[elementName] = $('form [name='+elementName+']').prop('checked');
				}
			}
			else {
				if ($('form [name='+elementName+']').attr('name')) {
					var elementValue = $('form [name='+elementName+']').val();
					if ($('form [name='+elementName+']').attr('name')=='word') {
						var article = checkArticle(elementValue);
						if (article) {
							elementValue = elementValue.substr(article.length+1);
							// тут вызов автозаполнения для артикля (начало хардкода)
							if (article=='der' || article=='die' || article=='das' || article=='die_plural') {
								result['word_type'] = 'noun';
								result['article_type'] = article;
							}
							else if (article=='sich') {
								result['word_type'] = 'verb';
								result['sich'] = true;
							}
							// конец хардкода
						}
					}
					result[elementName] = elementValue;
				}
			}
		}
	}
	var LabelsArr = $('.addedLabels, .labelsBlock').children('input:checkbox:checked');
	if (LabelsArr.length>0) {
		var labels = [];
		for (var i=0; i<LabelsArr.length; i++) {
			labels[i] = $(LabelsArr[i]).val();
		}
		result['labels'] = labels;
	}
	console.log(result);
	return result;
}

// Отделяем род и sich если они прописаны вместе со словом
function checkArticle (word) {
	var result = false;
	word = word.toLowerCase();
	if (word.indexOf("der ")==0 || word.indexOf("das ")==0 || word.indexOf("die ")==0) {
		result = word.substr(0,3);
	}
	else if (word.indexOf("die_plural ")==0) {
		result = 'die_plural';
	}
	else if (word.indexOf("sich ")==0) {
		result = 'sich';
	}
    return result;
}

// Валидируем текстовые инпуты
function textValidator(obj) {
	var result = false;
	if (obj['word'] || obj['translation']) {
		if (!/[^a-zA-ZÜüÖöÄäß,()\s]/.test(obj['word']) && !/[^а-яА-ЯёЁ()\/,-\s]/.test(obj['translation'])) {
			result = true;
		}
	}
	else if ($(obj).attr('type')) {
		var objValue = $(obj).val();
		if(/[^а-яА-ЯёЁ()\/,-\s]/.test(objValue) && $(obj).hasClass('input_russian')) {
			$(obj).addClass('notValidate');
		}
		else if (/[^a-zA-ZÜüÖöÄäß()\/,-\s]/.test(objValue) && $(obj).hasClass('input_german')) {
			$(obj).addClass('notValidate');
		}
		else {
			$(obj).removeClass('notValidate');
			result = true;
		}
	}
    return result;
}

// Посылаем данные через ajax на сервер
function sendData(arr, type) {
	var dataForSend = "";
	if (type) {
	dataForSend += "type="+type+"&";
	}
	
	for (var key in arr) {
		if (arr[key]) {
			dataForSend += ''+key+'='+String(arr[key])+'&';
		}
	}
	dataForSend = dataForSend.slice(0,-1);
	console.log(dataForSend);
	$.ajax({
		type: 'POST',
		url: 'word_in_DB.php',
		data: dataForSend,
		success: function(data){
			data = JSON.parse(data);
			if (data['result']=='success') {
				popUpWindow('Word '+'<span class="radius success label">'+arr['word']+'</span>'+' was successful added!','success', 1000);
				clear();
				hideParam();
			}
		else if (data['result']=='double') {
				popUpWindow('<div class="repetition"><div class="label secondary"><h1>Word is already in Database!</h1></div>'+'<article class="card small-8 small-offset-2" data-id-word='+data['object']['id']+' data-importance-word="'+data['object']['importance']+'"><div class="image"><div class="image-container"></div><div class="card-container word-container medium-12"><h2 class="word">'+data['object']['article']+' '+data['object']['word']+'</h2><h5 class="word-forms">'+'Word forms'+'</h5><h5 class="add-word-params">'+'Add params'+'</h5></div></div><div class="card-content"><div class="card-container"><h3 class="translate">'+data['object']['translate']+'</h3></div></div></article>'+'<a class="button success add_without_test small-10 small-offset-1">Все равно добавить</a>'+'<a class="button info small-10 small-offset-1 addValue">Добавить доп. значение</a>'+'<a class="button alert small-10 small-offset-1 cancel">Отмена</a>'+'</div>'+'<a class="close-reveal-modal" aria-label="Close">×</a>');
				putWordsInCard(data['object']);
			}
		}
	});
}

function composeAddParams(arr) {
	addWordParams = '';
	var cnt = 0;
	for (var key in arr) {
		if (arr[key] && (key!='id' && key!='word' && key!='translate' && key!='article' && key!='date' && key!='created_date' && key!='hide' && key!='themes' && key!='examples' && key!='image')) {
			if (cnt>0) {
				addWordParams += ', ';
			}
			addWordParams += '<a href="#">'+arr[key]+'</a>';
			cnt++;
		}
	}
    return addWordParams;
}

function getAddDate(arr) {
	var result = false;
	if (arr['date']) {
		result = arr['date'];
	}
    return result;
}







function changeParam(id, column, val){
	if (id && column && val){
		var dataForSend = 'id='+id+'&column='+column+'&val='+val+'';
		$.ajax({
			type: 'POST',
			url: 'change_word_in_DB.php',
			data: dataForSend,
			success: function(data){
				data = JSON.parse(data);
				if (data['result']=='success') {
					popUpWindow('Word '+'<span class="radius success label"></span>'+' was successful changed!','success', 1000);
					clear();
					hideParam();
				}
			}
		});
	}
}			

// Получаем только уникальные значения поля перевод
function get_unique_new_translation(){
	var newValue = [];
	newValue = $('#translation_text').val();
	if (newValue) {
		//newValue = $(newValue).split(', ');
	}
	var oldValue = [];
	oldValue = $('#myModal').find('.translate').html().split(', ');
	if (oldValue) {
		newValue = newValue.concat(oldValue);
	}
	var dataForSend = 'value='+newValue+'';
	$.ajax({
		async: false,
		type: 'POST',
		url: 'get_unique_new_translation_from_DB.php',
		data: dataForSend,
		success: function(data){
			data = JSON.parse(data);
			if (data['result']=='success') {
				newValue = data['object'];
			}
		}
	});
	return newValue;
}

function add_value(id, column, val){
	if (id && column && val){
		var dataForSend = 'id='+id+'&column='+column+'&val='+val+'';
		$.ajax({
			type: 'POST',
			url: 'add_value_in_DB.php',
			data: dataForSend,
			success: function(data){
				data = JSON.parse(data);
				if (data['result']=='success') {
					popUpWindow('Word '+'<span class="radius success label"></span>'+' was successful changed!','success', 1000);
					clear();
					hideParam();
				}
			}
		});
	}
}





function clear_pictureChoose(parentObj){
    if (parentObj) {
    	$(parentObj).find('.pictureChoose__result').empty();
    	$(parentObj).find('.pictureChoose__noresult').removeClass('hide');
    }
}
*/




