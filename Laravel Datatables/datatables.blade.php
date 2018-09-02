<!DOCTYPE html>
<html>
<head>
	<title>Datatables</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" type="text/css" href="vendor/Bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/DataTables/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/DataTables/css/responsive.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/DataTables/css/fixedColumns.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker-master/daterangepicker.css"/>
	
	<script type="text/javascript" src="vendor/DataTables/js/jquery.js"></script>
 	<script type="text/javascript" src="vendor/Bootstrap/js/bootstrap.min.js"></script>
 	<script type="text/javascript" src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
 	<script type="text/javascript" src="vendor/DataTables/js/dataTables.responsive.min.js"></script>
 	<script type="text/javascript" src="vendor/daterangepicker-master/moment.min.js"></script>
 	<script type="text/javascript" src="vendor/daterangepicker-master/daterangepicker.js"></script>

	<style type="text/css">
		/**/
	</style>

	<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
	</script>
</head>
<body>

	<form style="margin-bottom: 20px">
        <select id="name" name="supplier" style="height: 27px">
          <option value="all">ALL</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
        <input type="text" name="periode" value="{{$periode}}" id="periode" placeholder="Tanggal Created">
      	<button type="button" id="btnFilter">Filter</button>
    </form>

	<table class="table table-bordered display responsive nowrap" id="users-table" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>No</th>
                <th>Name</th>
                <th>phone</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
 	
	<script>

	    $('#periode').daterangepicker({
            locale: {
              format: 'DD/MM/YYYY'
            }
        });

	    var table = $('#users-table').DataTable({
	        processing: true,
	        serverSide: true,
	        responsive: true,
	        ordering: true,
	        ajax: {
                'url': '{!! route('datatables.data') !!}',
                'type': 'POST',
                'data': function(d){
                	d.name    = $('#name').val(); 
                  d.periode = $('#periode').val();
                }
            },
	        columns: [
	        	{ data: null,
	        	  bSearchable: false,
	        	  sortable: false,
	        	  responsivePriority: 1,
	        	  render: function (data, type, row, meta) {
			        return meta.row + meta.settings._iDisplayStart + 1;
			      }
	        	},
	            { data: 'name', name: 'name', visible: true, responsivePriority: 2},
	            { data: 'phone', name: 'phone', visible: true},
	            { data: 'created_at', name: 'created_at', visible: true, },
	            { data: 'updated_at', name: 'updated_at', visible: true},
	            {
			      data: null,
			      bSearchable: false,
			      responsivePriority: 3,
			      render: function(data, type) {
			      	return '<button>View</button>'+
			      		   '<button>Edit</button>'+
			      		   '<button onclick="deleted('+data.id+')">Delete</button>';
			      }
			    }
	        ],
	        columnDefs: [
	            { width: 10, targets: 0 },
	        ],
	        rowCallback: function (row, data) {
	           $(row).addClass('fontThick');
	        }
	    });

        $( "#btnFilter" ).click(function() {
            table.draw();
        });

		function deleted(user_id){
			$.ajax({
				type: "DELETE",
				url: "{!! route('datatables') !!}/" + user_id,
				cache: false,
				success: function(data){
				    table.ajax.reload();
				}
			});
		}
	</script>
</body>

</html>
