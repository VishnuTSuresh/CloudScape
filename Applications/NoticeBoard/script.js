$(function(){
	var pstyle = 'background-color: white; border: 1px solid #dfdfdf; padding: 5px;';
	var prev_window_size;
	function resizeNoticeBoard(){
		if(prev_window_size!=$(window).height()){
			var nb= $("#notice_board");
			var displayHeight=$(window).height() -nb.offset().top -30;
			nb.height(displayHeight);
			w2ui["notice_board"].resize();
			prev_window_size=$(window).height();
		}
	}
	var rid=0;
	var notice_list=$().w2grid({ 
		name: 'notice_list', 
		url: 'w2ui.php',
		multiSelect:false,
		show :{
			toolbar         : true,
			toolbarReload   : true,
			toolbarColumns  : true,
			toolbarSearch   : true,
			footer			: true,
			expandColumn	: true,
		},
		columns: [				
			{ field: 'title', caption: 'Title', size: '60%',resizable: true },
			{ field: 'uploader', caption: 'Uploader', size: '30%',resizable: true },
			{ field: 'date', caption: 'Date', size: '60px',resizable: true , render:'date'},
		],
		multiSearch : true,
		searches : [
			{ field: 'title', caption: 'Title', type: 'text' },
			{ field: 'uploader', caption: 'Uploader', type: 'text' },
			{ field: 'date', caption: 'Date', type: 'date' },
		],
		onSelect: function(event) {
			rid++;
			$.getJSON("getContentJSON.php",{"rid":rid,"nid":event.recid},function(data){
				if(data.rid==rid){
					w2ui["notice_board"].content("main",data.content);
				}
			});
		}
	});
	$("#notice_board").w2layout({
		name    : 'notice_board',
		panels  : [
		            //{ type: 'top',  size: 50, resizable: true, style: pstyle, content: 'top' },
		            { type: 'left', size: 300, resizable: true, style: pstyle, content: notice_list },
		            { type: 'main', style: pstyle, content: 'main' },
		            //{ type: 'preview', size: '50%', resizable: true, style: pstyle, content: 'preview' },
		            //{ type: 'right', size: 200, resizable: true, style: pstyle, content: 'right' },
		            //{ type: 'bottom', size: 50, resizable: true, style: pstyle, content: 'bottom' }
		        ]
	});
	resizeNoticeBoard();
	$(window).resize(resizeNoticeBoard);
});