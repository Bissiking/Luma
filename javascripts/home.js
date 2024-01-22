var TempPing = 0;

function TEST() {
	value = Math.floor(Math.random() * 5) + 1;
	return value;
}

function SearchAndPing() {
	// On compte le nombre de bloc serveur disponible
	let CountBlockServer = $('.ServerBlock').length;
	// On effectue une boucle avec le nombre de bloc disponible
	for (let i = 0; i < CountBlockServer ; i++) {
		
		// On selectionne la DIV
		let deuxiemeServerBlock = $('.ServerBlock')[i];
		// Puis on cible une DIV
		let idElement = deuxiemeServerBlock.id;
		// On récupère les information nécessaire
		let ip = $('#'+idElement).data('ip');
		// On injecte les informations dans l'autre fonction
		
		setTimeout(() => {
			CheckServiceLuma(ip, idElement);
		}, TEST()*1000);
	}
}

function CheckServiceLuma(url, idelement) {
	let offlineBackground = 'linear-gradient(45deg, #dc3545, #dc3545)';

	// Nettoyage des classes
	$('#status_'+idelement).removeClass('offline');
	$('#status_'+idelement).removeClass('online');
	$('#status_'+idelement).removeClass('warning');
	$('#status_'+idelement).text('Checking ...');

	if (url == "offline") {
		$('#ping_'+idelement).css('background', offlineBackground);
		$('#ping_'+idelement).text('NaN');
		$('#status_'+idelement).addClass('offline');
		$('#status_'+idelement).text('Hors Ligne');
		return;
	}else if (url == "") {
		$('#ping_'+idelement).css('background', offlineBackground);
		$('#ping_'+idelement).text('NaN');
		$('#status_'+idelement).addClass('offline');
		$('#status_'+idelement).text('Hors Ligne');
		return;
	}

	// TEST DU PING
	var avg = 0,
		cpt = 0,
		i=0;
		for(i=0; i<1;i++){
			var start = $.now();            
			$.ajax({ type: "HEAD",
				url: "https://"+url,
				cache:false,
				timeout: 2000,
				complete: function(output){ 
					var ping = $.now() - start;
					if (ping < 1000) { // useless?
						cpt++;
						avg+= ping/cpt - avg/cpt; //update average val
						if(avg <= 150) {
							$('#ping_'+idelement).css('background', 'linear-gradient(45deg, #007bff, #4caf50)');
							$('#ping_'+idelement).text(avg+'ms');
						
							$('#status_'+idelement).text('En ligne');
							$('#status_'+idelement).addClass('online');
						
						} else if (avg <= 500) {
							$('#ping_'+idelement).css('background', 'linear-gradient(45deg, #ff9900, #4caf50)');
							$('#ping_'+idelement).text(avg+'ms');
						
							$('#status_'+idelement).text('En ligne');
							$('#status_'+idelement).addClass('online');
						} else {
							$('#ping_'+idelement).css('background', 'linear-gradient(45deg, #ff9900, #dc3545)');
							$('#ping_'+idelement).text(avg+'ms');
						
							$('#status_'+idelement).text('Instable');
							$('#status_'+idelement).addClass('warning');
						}                               
					}
				},
				error: function name(output) {
					$('#ping_'+idelement).css('background', 'linear-gradient(45deg, #ff0000a1, #9c0505)');
					$('#ping_'+idelement).text('NaN');
					$('#status_'+idelement).text('Hors ligne');
					$('#status_'+idelement).addClass('offline');
				}
			});
		}         
}

SearchAndPing();
setInterval(() => {
	SearchAndPing();
}, 20000);





// ----------

// function ping(url) {
// 	return $.ajax({
// 		url: url,
// 		type: 'GET',
// 		timeout: 5000, // Timeout de la requête en millisecondes (ajustez selon vos besoins)
// 	});
// }

// // Exemple d'utilisation
// ping('http://localhost:8000')
// 	.done(function(data, textStatus, jqXHR) {
// 		console.log('Site accessible:', textStatus);
// 	})
// 	.fail(function(jqXHR, textStatus, errorThrown) {
// 		console.error('Erreur lors de la requête:', textStatus);
// 	});