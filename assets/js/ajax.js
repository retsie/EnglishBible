var tempBookId;
var tempChapId;
var tempVerseId;
var tempBookName;
var typingTimer;
var testament = "all";
var preBook;
var preChapter;
function loadBookList(   ){
	var params = "action=bookList"; 
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#selector").html('<font color="aqua">loading...</font>')
		},
		success: function(html) {
			$("#selector").html(html);
		}
	});
}

function loadChapter(book_id, BookName){
	var params = "action=chapter&book_id="+book_id; 
	tempBookId = book_id;
	tempBookName = BookName;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#selector").html('<font color="aqua">loading...</font>')
		},
		success: function(html) {
			$("#selector").html(html);
			$("#bookList").html(BookName);
		}
	});
}

function loadVerse(chapter_number){
	var params = "action=verse&chapter_number="+chapter_number+"&book_id="+tempBookId;
	tempChapId = chapter_number;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#selector").html('<font color="aqua">loading...</font>')
		},
		success: function(html) {
			$("#selector").html(html);
			$("#chapter").html(chapter_number);
		}
	});
}

function loadBack(){
	var params = "action=back&chapter_number="+tempChapId+"&book_id="+tempBookId+"&verse_number="+tempVerseId;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#phrase").html('<font color="aqua">loading...</font>');
		},
		success: function(html) {
		     var out = $.parseJSON(html);
		     $("#verse").html(out['verse']);
		     $("#sitas").html(out['bookname']+" "+out['chapter']+":"+out['verse']);
			$("#phrase").html(out['phrase']);
			tempBookId = out['book'];
               tempChapId = out['chapter'];
               tempVerseId = out['verse'];
               tempBookName = out['bookname'];
              // console.log(out['note']);
		}
	});
}

function loadForward(){
	var params = "action=forward&chapter_number="+tempChapId+"&book_id="+tempBookId+"&verse_number="+tempVerseId;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#phrase").html('<font color="aqua">loading...</font>')
		},
		success: function(html) {
		     var out = $.parseJSON(html);
		     $("#verse").html(out['verse']);
		     $("#sitas").html(out['bookname']+" "+out['chapter']+":"+out['verse']);
			$("#phrase").html(out['phrase']);
			tempBookId = out['book'];
               tempChapId = out['chapter'];
               tempVerseId = out['verse'];
               tempBookName = out['bookname'];
		}
	});
}

function loadBible(verse_number){
	var params = "action=getBible&chapter_number="+tempChapId+"&book_id="+tempBookId+"&verse_number="+verse_number;
	tempVerseId = verse_number;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#phrase").html('<font color="aqua">loading...</font>')
		},
		success: function(html) {
		     $("#verse").html(verse_number);
		     $("#sitas").html(tempBookName+" "+tempChapId+":"+tempVerseId);
			$("#phrase").html(html);
			preBook = tempBookName;
	          preChapter = tempChapId;
		}
	});
}
function typeSearch(){
     clearTimeout(typingTimer);
     typingTimer = setTimeout(function(){
          searchPhrase($("#inputSearch").val());
     }, 1000);
     return true;
}
function searchPhrase(query){
	var params = "action=search&searchQuery="+query+"&testament="+testament;
	var url= "operator/controller.php";
	$.ajax({
		type: 'POST',
		url: url,
		dataType: 'html',
		data: params,
		beforeSend: function() {
			$("#results").html('<font color="aqua">Searching...</font>')
		},
		success: function(html) {
			$("#results").html(html);
		}
	});
}

function loadPhrase(BookName, book_id, chapter_number, verse_number){
     tempChapId = chapter_number;
     tempBookId = book_id;
     tempBookName = BookName;
     tempVerseId = verse_number;
     $("#bookList").html(BookName);
     $("#chapter").html(chapter_number);
     loadBible(verse_number);
}

function initialVerse(){
     tempChapId = 1;
     tempBookId = 1;
     tempBookName = "Genesis";
     tempVerseId = 1;
     $("#bookList").html(tempBookName);
     $("#chapter").html(1);
     loadBible(1);
} 
