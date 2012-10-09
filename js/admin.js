$(function(){

	$("#tabs").tabs().tabs("select", '#generaloptions');
	
	$item_list	= $('ul.sortable');
	$url		= 'admin/firesale/documentation/order';
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
		
		$.getJSON(SITE_URL + 'admin/documentation/ajax_details/' + $details_id.val(), function(data) {


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
	
});
