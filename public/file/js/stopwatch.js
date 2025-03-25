$(document).ready(function () {
    let storedTime = localStorage.getItem('sessionTimeLeft');
    let initialTime = parseInt(localStorage.getItem('sessionInitialTime')) || 0;

    // Se houver tempo salvo, usa ele, senão usa o tempo inicial da sessão
    let countdownTime = storedTime !== null ? parseInt(storedTime) : initialTime;

    function formatTime(seconds) {
        let hours = Math.floor(seconds / 3600);
        let minutes = Math.floor((seconds % 3600) / 60);
        let secs = seconds % 60;

        return (
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(secs).padStart(2, '0')
        );
    }

    function displayTime() {
        $('#timer').text(formatTime(countdownTime));
    }

    let interval = setInterval(function () {
        if (countdownTime <= 0) {
            clearInterval(interval);
            localStorage.removeItem('sessionTimeLeft'); // Remove o localStorage quando o tempo expira

            msgPopup('alert', 'Ops! Tempo esgotado.');

            setTimeout(function() {
                $.ajax({
                    url: '/booth/logout',
                    type: 'GET',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        window.location.href = '/booth';
                    }
                });
            }, 3000);
        } else {
            countdownTime--;
            localStorage.setItem('sessionTimeLeft', countdownTime); // Salva o tempo restante
            displayTime();
        }
    }, 1000);

    displayTime();
});
