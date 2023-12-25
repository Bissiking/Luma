function PingTest(url, serverId) {
    var $test_text = $('#ping_bdd_luma')
    var pingCircle = document.getElementById('pingCircle' + serverId.slice(-1));
    var avg = 0;

    // Fonction qui sera appelée toutes les secondes
    function incrementCounter() {
        avg++;
        $test_text.text(avg);
        if(avg <= 5) {
            $('#ping_bdd_luma').css('background', 'linear-gradient(45deg, #4caf50, #007bff)');
        } else if (avg <= 10) {
            $('#ping_bdd_luma').css('background', 'linear-gradient(45deg, #ff9900, #bdba03)');
        } else {
            $('#ping_bdd_luma').css('background', 'linear-gradient(45deg, #dc3545, #ff8c94)');
        }  
        console.log(avg);
    }

    // Démarrez la boucle toutes les secondes (1000 millisecondes)
    // intervalId = setInterval(incrementCounter, 1000);

	var msg = this.id,
		ip = $(this).data("ip"),
		avg = 0,
		cpt = 0,
		i=0;
	for(i=0; i<1;i++){
		var start = $.now();            
		$.ajax({ type: "HEAD",
			url: "http://"+ip,
			cache:false,
			complete: function(output){ 
				var ping = $.now() - start;
				if (ping < 1000) { // useless?
					cpt++;
					avg+= ping/cpt - avg/cpt; //update average val
					$("#"+msg).text(avg+" ms (on "+cpt+"tests)");
                              
				}
			}
		});
	}        
}

PingTest('test', 'ping_bdd_luma'); 