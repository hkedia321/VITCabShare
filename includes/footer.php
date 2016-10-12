
<script>
// Initialize collapse button
$(".button-collapse").sideNav();
  // Initialize collapsible (uncomment the line below if you use the dropdown variation)
  //$('.collapsible').collapsible();



  $('.button-collapse').sideNav({
      menuWidth: 260, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: false // Closes side-nav on <a> clicks, useful for Angular/Meteor
  }
  );
</script>
<script>
	$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
});
</script>
<script>
	$(document).ready(function() {
		$('select').material_select();
	});
	$(document).ready(function() {  
		$(document).on('change','#from',function(){
			var i=$(this).val();
			i=2+i;
			var j;
			for(j=20;j<=24;j++)
				$("#"+j).removeAttr("disabled");
			$("#"+i).attr("disabled","true");
			$('select').material_select();
		});
	});
	
	$(document).ready(function() {  
		$(document).on('change','#to',function(){
			var i=$(this).val();
			i=1+i;
			var j;
			for(j=10;j<=14;j++)
				$("#"+j).removeAttr("disabled");
			$("#"+i).attr("disabled","true");
			$('select').material_select();
		});
	});
	$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 2 // Creates a dropdown of 15 years to control year
});
</script>
<script type="text/javascript">
	function closenav(){
		$('.button-collapse').sideNav('hide');
	}

	$(".close-button-nav").click(function(){
		closenav();
	});
</script>
</body>
</html>