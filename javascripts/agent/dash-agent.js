var uuid = $('#agent-uuid').text();
var url = "/data/" + uuid + "/";

function ModelProcessor() {
    $.ajax({
        url: url + "processor-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result.status.cpu;
            $('#data-agent-ModelProcessor').text(data.model)
            $('#data-agent-architecture').text(data.architecture)
            $('#data-agent-Cores').text(data.cores)
            $('#data-agent-Used').text(data.usage)
            $('#data-agent-processorUpdate').text(response.result.status.date)
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function Memory() {
    $.ajax({
        url: url + "memory-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result.status.memory;
            $('#data-agent-Memfree').text(data.free)
            $('#data-agent-MemTotal').text(data.total)
            $('#data-agent-memoryUpdate').text(response.result.status.date)
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function ServicesPlex() {
    $.ajax({
        url: url + "plex-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result;

            if (data.status == 1) {
                statsTxt = 'En fonctionnement';
            } else {
                statsTxt = 'Service stoppé'
            }

            $('#data-agent-plex').text(statsTxt)
            $('#data-agent-servicesUpdate').text(data.date)
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

// function Disk() {
//     $.ajax({
//         url: url + "memory-data.json",
//         dataType: 'json',
//         success: function (response) {
//             let data = response.result.status.memory;
//             $('#data-agent-Memfree').text(data.free)
//             $('#data-agent-MemTotal').text(data.total)
//             $('#data-agent-memoryUpdate').text(response.result.status.date)
//         },
//         error: function (error) {
//             console.error('Erreur lors du chargement du fichier JSON :', error);
//         }
//     });
// }

// FISRT START
ModelProcessor();
ServicesPlex();
Memory();

setTimeout(() => {
    ModelProcessor();
    ServicesPlex();
    Memory();
}, 20000);