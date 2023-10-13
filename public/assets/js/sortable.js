	$(function() {
			$('.sortable').sortable({
			
				update:function(event,ui){
					
					var postData = $(this).sortable('serialize');
					console.log(postData);
					$.post('save.php',{list:postData},function(o){
					console.log(o);
					},'json');
				}
				
			});
		});
		
