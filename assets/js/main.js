$('.tabledefault').DataTable({
	"aLengthMenu": [[5], [5]],
	'order': [[1, 'asc']],
	order: [[ 1, 'asc' ]]
});

var table_asc = $('.tablecheckbox_asc').DataTable({
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

var table_desc = $('.tablecheckbox_desc').DataTable({
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

var current = location.search.substr(1) ? location.search.substr(1) : './';
$('.nav li a').each(function(){
	var $this = $(this);
	if($this.attr('href').indexOf(current) !== -1){
		$this.parents('li').addClass('active')
	}
})

$(".chosen").chosen();