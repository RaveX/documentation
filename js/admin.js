$(function(){

	$("#tabs").tabs().tabs("select", '#generaloptions');
	
	$item_list	= $('ul.sortable');
	$url		= 'admin/documentation/order';
	$cookie		= 'open_docs';
	
	$details 	= $('div#documentation-sort');
	$details.append('<input type="hidden" name="doc-id" id="doc-id" value="" />');
	$details_id	= $('div#documentation-sort #doc-id');
		
	$item_list.find('li a').live('click', function(e) {

		e.preventDefault();
		$a = $(this);
			
		doc_id		= $a.attr('rel');
		doc_title 	= $a.text();
		$('#documentatio-sort a').removeClass('selected');
		$a.addClass('selected');
		$details_id.val(doc_id);
		
		$.getJSON(SITE_URL + 'admin/documentation/details/' + $details_id.val(), function(data) {
			if( typeof data.id != 'undefined' )
			{
				var form = $('.one_half.last fieldset');
				var btns = $('.one_half.last .buttons');
				form.find('input[name=id]').val(data.id);
				form.find('input[name=title]').val(data.title);
				form.find('input[name=slug]').val(data.slug);
				form.find('select[name=parent]').val(data.parent).trigger('liszt:updated');
				form.find('input[name=keywords]').val(data.keywords);
				form.find('input[name=description]').val(data.description);
				btns.find('.edit').attr('href', '/admin/documentation/edit/'+data.id);
				form.show();
				btns.show();
			}
		});
		
		return false;
	});
	
	data_callback = function(even, ui) {

		root_docs = [];
	
		$('ul.sortable').children('li').each(function(){
			root_docs.push($(this).attr('id').replace('doc_', ''));
		});
	
		return { 'root_docs' : root_docs };
	}
	
	post_sort_callback = function() {		
		$details 	= $('div#documentation-sort');
		$details_id	= $('div#documentation-sort #doc-id');
	}

	pyro.sort_tree($item_list, $url, $cookie, data_callback, post_sort_callback);
	
	pyro.generate_slug($('input[name=title]'), $('input[name=slug]'), '-');

	if( $('textarea[name=document]').size() > 0 )
	{
		var timer;
		$('textarea[name=document]').bind('keyup keydown delete paste change', function() {
			clearTimeout(timer);
			var doc = $(this).val();
			timer = setTimeout(function() {
				$.post('/admin/documentation/preview', {document: doc}, function(data) {
					$('.preview').html(data);
				});
			}, 200);
		});
	}
	
});
