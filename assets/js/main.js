(function(){
	var doc = document,
	kurl = "https://fb.com/he.irfaandemmy",
	klength = "110",
	kname = "Irfaan",
	kid = doc.getElementById('kurteyki'),
	kidlink = doc.getElementById('credit'),
	ckid = kid ? true : false;
	ckidlink = kidlink ? true : false;
	if (ckid && ckidlink) {

		var kidh = kid.innerHTML,
		kidlinkh = kidlink.innerHTML,
		kidlinkhref = kidlink.href,
		kidl = kidh.length,
		kidcs = kid.getAttribute('style') ? true : false,
		kidcc = kid.className ? true : false,
		style = {
			display : "initial !important",
			fontSize : "100% !important",
			visibility : "visible !important"
		},
		kidstyle = "display:"+style.display+";font-size:"+style.fontSize+";visibility:"+style.visibility+"",
		kidcstatus,
		kidstatus;	

		if (kidlinkhref !== kurl) {				
			kidstatus = true;
			console.log('URL Berubah');
		}else if (kidl < klength) {
			kidstatus = true;
			console.log('Element Kurang');
		}else if (kidl > klength) {
			kidstatus = true;
			console.log('Element Lebih');
		}else if (kidlinkh !== kname) {
			kidstatus = true;
			console.log('Element Tidak Sama');
		}else if (kidcs) {
			kidstatus = true;
			console.log('Element Memiliki Style');
		}else if (kidcc) {
			kidstatus = true;
			console.log('Element Memiliki Class');
		}else {
			kid.style = kidstyle;
			kidlink.style = kidstyle;
		}

		document.onreadystatechange = function(){
			if(document.readyState === 'complete'){						
				if (kid.style.display === "" || kidlink.style.display === "") {
					kidcstatus = true;
					console.log('Display Kosong');
				}else if (kid.style.visibility === "" || kidlink.style.visibility === "") {
					kidcstatus = true;
					console.log('Visibility Kosong');
				}else if (kid.style.fontSize === "" || kidlink.style.fontSize === "") {
					kidcstatus = true;
					console.log('Font Size Kosong');
				}else if (kid.style.display !== "initial" || kidlink.style.display !== "initial") {
					kidcstatus = true;
					console.log('Display Bukan Initial');
				}else if (kid.style.visibility !== "visible" || kidlink.style.visibility !== "visible") {
					kidcstatus = true;
					console.log('Visibility Bukan Visible');
				}else if (kid.style.fontSize !== "100%" || kidlink.style.fontSize !== "100%") {
					kidcstatus = true;
					console.log('Font Size Bukan 100%');
				}
				if (kidcstatus) {
					kid.style = kidstyle;
					kidlink.style = kidstyle;
				}
				if (kidstatus) {
					console.log('Element Hilang');
					window.location.href=kurl;
				}
			}
		}

	}else {		
		console.log('Element Hilang');
		window.location.href=kurl;
	}		

})();

$(".chosen").chosen();

$('.tableUser').DataTable({
	"aLengthMenu": [[5], [5]],
	'order': [[1, 'asc']],
	order: [[ 1, 'asc' ]]
});

var table = $('.tablecheckbox').DataTable({
	"aLengthMenu": [[5,10,50,100,1000], [5,10,50,100,1000]],
	'order': [[1, 'asc']],
	'columnDefs': [
	{
		'targets': 0,
		'checkboxes': {
			'selectRow': true
		}
	}
	],
	'select': {
		'style': 'multi'
	},
});

$('.formtablecheckbox').on('submit', function(e){
	var form = this;
	var rows_selected = table.column(0).checkboxes.selected();
	$.each(rows_selected, function(index, rowId){
		$(form).append(
			$('<input>')
			.attr('type', 'hidden')
			.attr('name', 'target[]')
			.val(rowId)
			);
	});
});

var tablesortdesc = $('.tablecheckboxdesc').DataTable({
	"aLengthMenu": [[5,10,50,100,1000], [5,10,50,100,1000]],
	'order': [[1, 'desc']],
	'columnDefs': [
	{
		'targets': 0,
		'checkboxes': {
			'selectRow': true
		}
	}
	],
	'select': {
		'style': 'multi'
	},
});

$('.formtablecheckbox').on('submit', function(e){
	var form = this;
	var rows_selected = tablesortdesc.column(0).checkboxes.selected();
	$.each(rows_selected, function(index, rowId){
		$(form).append(
			$('<input>')
			.attr('type', 'hidden')
			.attr('name', 'target[]')
			.val(rowId)
			);
	});
});

var current = location.search.substr(1) ? location.search.substr(1) : './';
$('.nav li a').each(function(){
	var $this = $(this);
	if($this.attr('href').indexOf(current) !== -1){
		$this.parents('li').addClass('active')
	}
})